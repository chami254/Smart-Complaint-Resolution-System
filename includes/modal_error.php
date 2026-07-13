<!-- ==========================================
     ERROR MODAL
=========================================== -->

<div id="errorModal" class="modal">

    <div class="modal-content">

        <span class="close-modal">&times;</span>

        <div class="modal-icon error-icon">

            <i class="fa-solid fa-circle-xmark"></i>

        </div>

        <h2><?= htmlspecialchars($errorTitle ?? "Something Went Wrong") ?></h2>

        <p><?= htmlspecialchars($errorMessage ?? "") ?></p>

        <div class="modal-buttons">

            <button
                type="button"
                class="btn btn-danger close-btn">

                Close

            </button>

        </div>

    </div>

</div>