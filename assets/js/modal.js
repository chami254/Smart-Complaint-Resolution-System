document.addEventListener("DOMContentLoaded", () => {

    /* SUCCESS MODAL */

    const modal = document.getElementById("successModal");

    if (modal) {

        document.querySelectorAll(".close-btn,.close-modal").forEach(button => {

            button.addEventListener("click", () => {

                modal.classList.remove("show");

            });

        });

        const copyButton = document.getElementById("copyTicket");

        if (copyButton) {

            copyButton.addEventListener("click", () => {

                const ticket =
                    document.getElementById("ticketText").innerText;

                navigator.clipboard.writeText(ticket);

                copyButton.innerHTML =
                    '<i class="fa-solid fa-check"></i> Copied';

                setTimeout(() => {

                    copyButton.innerHTML =
                        '<i class="fa-regular fa-copy"></i> Copy';

                },2000);

            });

        }

    }

    /* CONFIRM MODAL */

    const confirmModal = document.getElementById("confirmModal");

    const logoutBtn = document.getElementById("logoutBtn");

    const confirmAction = document.getElementById("confirmAction");

    logoutBtn.addEventListener("click", function(e){

        e.preventDefault();
    
        console.log("Logout button clicked");
    
        confirmModal.classList.add("show");
    
    });

    if (confirmModal) {

        confirmModal.querySelectorAll(".close-btn,.close-modal").forEach(button=>{

            button.addEventListener("click",()=>{

                confirmModal.classList.remove("show");

            });

        });

    }

    if (confirmAction) {

        confirmAction.addEventListener("click", function(){

            const url = this.dataset.url;

            if(url){

                window.location.href = url;

            }

        });

    }

});