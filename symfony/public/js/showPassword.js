$(document).ready(() => {
  //test if jquery is install
  alert('jQuery est prêt à l\'utilisation')
  
  //function to show and hide password
  $('#checkbox').change(function (){
    if(this.checked){
      $('#inputPassword').type = "text";
    } else if(!this.checked){
      $('#inputPassword').type = "password";
    };
  });
})