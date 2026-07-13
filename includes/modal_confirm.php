<!-- ==========================================
     CONFIRMATION MODAL
=========================================== -->

<div id="confirmModal" class="modal">

    <div class="modal-content">

        <span class="close-modal">&times;</span>

        <div class="modal-icon confirm-icon">

            <i class="fa-solid fa-circle-question"></i>

        </div>

        <h2><?= htmlspecialchars($confirmTitle ?? "Confirmation") ?></h2>

        <p><?= htmlspecialchars($confirmMessage ?? "") ?></p>

        <div class="modal-buttons">

            <button
                type="button"
                id="confirmAction"
                class="btn btn-primary"
                data-url="<?= htmlspecialchars($confirmAction ?? "") ?>">

                Confirm

            </button>

            <button
                type="button"
                class="btn btn-secondary close-btn">

                Cancel

            </button>

        </div>

    </div>

</div>