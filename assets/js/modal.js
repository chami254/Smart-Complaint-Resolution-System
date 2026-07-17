/*=========================================
CONFIRMATION MODAL
=========================================*/

const confirmModal = document.getElementById("confirmModal");

const confirmAction = document.getElementById("confirmAction");

const logoutBtn = document.getElementById("logoutBtn");

const deleteBtn = document.getElementById("deleteAccountBtn");

if (confirmModal) {

    confirmModal.querySelectorAll(".close-btn,.close-modal").forEach(button => {

        button.addEventListener("click", () => {

            confirmModal.classList.remove("show");

        });

    });

}

/* Logout */

if (logoutBtn) {

    logoutBtn.addEventListener("click", function(e){

        e.preventDefault();

        confirmAction.dataset.url = "../logout.php";

        confirmModal.querySelector("h2").textContent = "Logout";

        confirmModal.querySelector("p").textContent =
            "You are about to end your current session. Continue?";

        confirmModal.classList.add("show");

    });

}

/* Delete Account */

if (deleteBtn) {

    deleteBtn.addEventListener("click", function(e){

        e.preventDefault();

        confirmAction.dataset.url = "delete_account.php";

        confirmModal.querySelector("h2").textContent = "Delete Account";

        confirmModal.querySelector("p").textContent =
            "This action is permanent. Your account and all complaints will be deleted.";

        confirmModal.classList.add("show");

    });

}

/* Confirm */

if (confirmAction) {

    confirmAction.addEventListener("click", function(){

        const url = this.dataset.url;

        if(url){

            window.location.href = url;

        }

    });

}