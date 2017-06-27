<?php

/**
 * Class ErrorView_Standard
 */
class ErrorView_Standard extends ErrorView {
	public function applyAjaxErrorResponse() {
		$id = $this->_form->getAttribute( "id" );
		echo <<<JS
        var errorSize = response.errors.length;
        if(errorSize == 1)
            var errorFormat = "error was";
        else
            var errorFormat = errorSize + " errors were";

        jQuery('.bf-alert').remove();
        var errorHTML = '<div class="bf-alert error"><strong class="alert-heading">The following ' + errorFormat + ' found:</strong><ul>';
        for(e = 0; e < errorSize; ++e)
            errorHTML += '<li>' + response.errors[e] + '</li>';
        errorHTML += '</ul></div>';
        jQuery("#$id").prepend(errorHTML);
JS;

	}

	public function render() {
		$errors = $this->_form->getErrors();
		if ( ! empty( $errors ) ) {
			$size   = sizeof( $errors );
			$errors = implode( "</li><li>", $errors );

			if ( $size == 1 ) {
				$format = "error was";
			} else {
				$format = $size . " errors were";
			}

			echo <<<HTML
            <div class="bf-alert error">
                <strong class="alert-heading">The following $format found:</strong>
                <ul><li>$errors</li></ul>
            </div>
HTML;
		}
	}

	public function renderAjaxErrorResponse() {
		$errors = $$this->_form->getErrors();
		if ( ! empty( $errors ) ) {
			header( "Content-type: application/json" );
			echo json_encode( array( "errors" => $errors ) );
		}
	}

	/**
	 * @param $errors
	 *
	 * @return array
	 */
	private function parse( $errors ) {

		$list = array();
		if ( ! empty( $errors ) ) {
			$keys    = array_keys( $errors );
			$keySize = sizeof( $keys );
			for ( $k = 0; $k < $keySize; ++ $k ) {
				$list = array_merge( $list, $errors[ $keys[ $k ] ] );
			}
		}

		return $list;
	}
}
