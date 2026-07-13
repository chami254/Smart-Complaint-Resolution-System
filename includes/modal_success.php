<!-- ==========================================
     SUCCESS MODAL
=========================================== -->

<div id="successModal" class="modal">

    <div class="modal-content">

        <span class="close-modal">&times;</span>

        <div class="modal-icon success-icon">

            <i class="fa-solid fa-circle-check"></i>

        </div>

        <h2><?= htmlspecialchars($modalTitle ?? "Success") ?></h2>

        <p><?= htmlspecialchars($modalMessage ?? "") ?></p>

        <?php if(!empty($ticketNo)): ?>

            <div class="ticket-box">

                <label>Your Ticket Number</label>

                <div class="ticket-number">

                    <span id="ticketText">

                        <?= htmlspecialchars($ticketNo) ?>

                    </span>

                    <button
                        type="button"
                        id="copyTicket"
                        class="copy-btn">

                        <i class="fa-regular fa-copy"></i>

                        Copy

                    </button>

                </div>

            </div>

        <?php endif; ?>

        <div class="modal-buttons">

            <a
                href="my_complaints.php"
                class="btn btn-primary">

                View My Complaints

            </a>

            <button
                type="button"
                class="btn btn-secondary close-btn">

                Submit Another

            </button>

        </div>

    </div>

</div>