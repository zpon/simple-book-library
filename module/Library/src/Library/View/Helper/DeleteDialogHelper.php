<?php

namespace Library\View\Helper;

use Zend\View\Helper\AbstractHelper;

class DeleteDialogHelper extends AbstractHelper {

    public function __invoke() {
        return '<div id="delete-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="delete-modal-label"></h3>
                </div>
                <div id="delete-modal-body" class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                    <a href="" class="actual-delete btn btn-danger">Delete</a>
                </div>
            </div>';
    }

}

?>
