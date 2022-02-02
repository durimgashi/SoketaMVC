<?=  isset($_SESSION['isLoggedIn']) ? 'Welcome ' . $_SESSION['firstName'] : '' ?>


<div class="container w-30">
    <form class="register-form">
        <div class="form-group">
            <label for="firstName">First Name</label><br>
            <input type="text" name="firstName" id="firstName" class="form-control">
        </div>
        <div class="form-group">
            <label for="lastName">Last Name</label><br>
            <input type="text" name="lastName" id="lastName" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Email</label><br>
            <input type="text" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Password</label><br>
            <input type="text" name="password" id="password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary register-button">Register</button>
    </form>
</div>


<script>
     async function register(formData) {
         return $.ajax({
             url: 'register',
             type: 'POST',
             dataType: "json",
             processData: false,
             contentType: false,
             data: formData
         })
    }

     $(".register-form").validate({
         rules: {
             firstName: {
                 required: true
             },
             lastName: {
                 required: true
             },
             email: {
                 required: true
             },
             password: {
                 required: true
             }
         },
         messages:{
             firstName: {
                 required: "Name please"
             }
         },
         submitHandler: async (form, e) => {
             e.preventDefault()

             let formData = new FormData()
             formData.append('firstName', $('#firstName').val())
             formData.append('lastName', $('#lastName').val())
             formData.append('email', $('#email').val())
             formData.append('password', $('#password').val())
             let result = await register(formData)
             console.log(result)
         }
     });

</script>