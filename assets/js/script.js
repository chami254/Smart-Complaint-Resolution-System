// PASSWORD VISIBILITY

function togglePassword(inputId, iconId){

  const input = document.getElementById(inputId);
  const icon = document.getElementById(iconId);

  icon.addEventListener("click",()=>{

      if(input.type==="password"){

          input.type="text";
          icon.classList.replace("fa-eye","fa-eye-slash");

      }else{

          input.type="password";
          icon.classList.replace("fa-eye-slash","fa-eye");

      }

  });

}

togglePassword("password","togglePassword");
togglePassword("confirmPassword","toggleConfirmPassword");

// PASSWORD STRENGTH

const password=document.getElementById("password");

const fill=document.getElementById("strength-fill");

const text=document.getElementById("strength-text");

password.addEventListener("keyup",()=>{

  const value=password.value;

  let strength=0;

  if(value.length>=8) strength++;

  if(/[A-Z]/.test(value)) strength++;

  if(/[0-9]/.test(value)) strength++;

  if(/[^A-Za-z0-9]/.test(value)) strength++;

  const widths=["0%","25%","50%","75%","100%"];

  const colors=[
      "#ef4444",
      "#ef4444",
      "#f59e0b",
      "#3b82f6",
      "#22c55e"
  ];

  const labels=[
      "",
      "Weak",
      "Fair",
      "Good",
      "Strong"
  ];

  fill.style.width=widths[strength];

  fill.style.background=colors[strength];

  text.textContent=labels[strength];

});

// PASSWORD MATCH

const confirm=document.getElementById("confirmPassword");

const match=document.getElementById("password-match");

confirm.addEventListener("keyup",()=>{

  if(confirm.value===""){

      match.textContent="";
      return;

  }

  if(password.value===confirm.value){

      match.style.color="#22c55e";
      match.textContent="✓ Passwords match";

  }else{

      match.style.color="#ef4444";
      match.textContent="✗ Passwords do not match";

  }

});

const attachment = document.getElementById("attachment");

const fileName = document.getElementById("file-name");

if (attachment) {

    attachment.addEventListener("change", function () {

        if (this.files.length > 0) {

            fileName.textContent = this.files[0].name;

        } else {

            fileName.textContent = "No file selected";

        }

    });

}