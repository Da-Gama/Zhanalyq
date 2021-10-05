<?php
session_start();
include_once 'sessionCheck.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>All tags</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"
                integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
                crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <style>
            ul.navbar-nav li{
                padding-left: 16px;
                padding-right: 16px;
            }
            .navbar {
                padding: 15px 140px 15px 150px;
            }
            .edit-container{
                display: flex;
                justify-content: space-evenly;
            }
            .personal-container, .password-container, .description-container{
                margin-top: 100px;
            }
            .password-container{
                width: 400px;
            }
            .description-container{
                width: 900px;
            }
        </style>

    </head>
    <body>

    <?php
    include_once "header.php";
    ?>

    <div class="container edit-container">
        <div class="personal-container">
            <h4 class="text-center">Personal Info</h4>
            <hr>
            <form style="width: 400px;">
                <div class="form-group">
                    <label for="input-first-name">First Name</label>
                    <input type="text" class="form-control" id="input-first-name" placeholder="Enter First Name" required="required" value="<?php echo $_SESSION['user']['firstName']?>">
                </div>
                <div class="form-group">
                    <label for="input-last-name">Last Name</label>
                    <input type="text" class="form-control" id="input-last-name" placeholder="Enter Last Name" required="required" value="<?php echo $_SESSION['user']['lastName']?>">
                </div>
                <div class="form-group">
                    <label for="input-birthdate">Birthday</label>
                    <input type="text" class="form-control" id="input-birthdate" placeholder="10-10-2010" required="required" value="<?php echo $_SESSION['user']['birthDate']?>">
                </div>
                <small class="form-text state" style="color: deepskyblue; display: none"></small>
                <div class="alert alert-danger" role="alert" id="personal-response" style="display: none;">
                    A simple danger alert—check it out!
                </div>
                <button type="button" class="btn btn-success btn-block" id="button-update-personal">Update</button>
            </form>
            <script>
                $('document').ready(function(){
                    $('input[type=text]').keypress(function(){
                        $('#personal-response').hide();
                    });
                    $('input[type=password').keypress(function(){
                        $('#password-response').hide();
                    });
                    $('#button-update-personal').click(function(){
                        firstName = $('#input-first-name').val();
                        lastName = $('#input-last-name').val();
                        birthDate = $('#input-birthdate').val();
                        if (firstName == ''){
                            $('#personal-response').show();
                            $('#personal-response').text('First Name cannot be empty');
                            return;
                        }
                        if (lastName == ''){
                            $('#personal-response').show();
                            $('#personal-response').text('Last Name cannot be empty');
                            return;
                        }
                        if (birthDate == ''){
                            $('#personal-response').show();
                            $('#personal-response').text('Birthday cannot be empty');
                            return;
                        }

                        //Post method for updating personal data
                        $.post('profileRequest.php', {updatePersonal: 'ok', firstName: firstName, lastName: lastName, birthday: birthDate, userID: <?php echo $_SESSION['user']['id']?>})
                            .done(function(msg){
                                if (msg['code'] == 200){
                                    alert('Successfully updated!');
                                    location.reload();
                                }
                                else{
                                    $('#personal-response').show();
                                    $('#personal-response').text('Error');
                                }
                            });
                    });

                    //Post method for updating password
                    $('#button-update-password').click(function(){
                        current_password = $('#current-password').val();
                        new_password = $('#new-password').val();
                        retype_password = $('#retype-password').val();
                        if (current_password == ''){
                            $('#password-response').show();
                            $('#password-response').text('Current password cannot be empty');
                            return;
                        }
                        $.post('profileRequest.php', {
                            updatePassword: 'ok',
                            current_password: current_password,
                            new_password: new_password,
                            retype_password: retype_password,
                            userID: <?php echo $_SESSION['user']['id']?>
                        }).done(function(msg){
                            if (msg['code'] == 200){
                                alert('Password updated successfully!');
                                location.reload();
                            }else{
                                $('#password-response').show();
                                $('#password-response').text(msg['message']);
                            }
                        });
                    });

                    //keypress is called when key is pressed
                    $('textarea').keypress(function(){
                        $('#description-response').hide();
                    });
                    $('#button-update-description').click(function(){
                        description = $('#description').val();
                        if (description == ''){
                            $('#description-response').show();
                            $('#description-response').text('Description cannot be empty');
                            return;
                        }

                        //jQuery Post method for updating description
                        $.post('profileRequest.php', {updateDescription: 'ok', description: description, userID: <?php echo $_SESSION['user']['id']?>})
                            .done(function(msg){
                                if (msg['code'] == 200){
                                    alert('Description updated successfully');
                                    location.reload();
                                }else{
                                    $('#description-response').show();
                                    $('#description-response').text('Error');
                                }
                            });
                    });
                });
            </script>
        </div>
        <div class="password-container">
            <h4 class="text-center">Update password</h4>
            <hr>
            <form>
                <div class="form-group">
                    <label for="current-password">Current password</label>
                    <input type="password" class="form-control" id="current-password" placeholder="Enter Current password" required="required">
                </div>
                <div class="form-group">
                    <label for="new-password">New password</label>
                    <input type="password" class="form-control" id="new-password" placeholder="Enter New password" required="required">
                </div>
                <div class="form-group">
                    <label for="retype-password">Re-type password</label>
                    <input type="password" class="form-control" id="retype-password" placeholder="Re-type password" required="required">
                </div>
                <small class="form-text state" style="color: deepskyblue; display: none"></small>
                <div class="alert alert-danger" role="alert" id="password-response" style="display: none;">
                    A simple danger alert—check it out!
                </div>
                <button type="button" class="btn btn-success btn-block" id="button-update-password">Update</button>
            </form>
        </div>
    </div>
    <div class="container edit-container mb-5">
        <div class="description-container">
            <h4 class="text-center">Update description</h4>
            <hr>
            <form>
                <div class="form-group">
                    <label for="description">About me</label>
                    <textarea class="form-control" id="description" rows="5" required="required"><?php echo $_SESSION['user']['description']?></textarea>
                </div>
                <div class="alert alert-danger" role="alert" id="description-response" style="display: none;">
                    A simple danger alert—check it out!
                </div>
                <button type="button" class="btn btn-success" id="button-update-description">Update description</button>
            </form>
        </div>
    </div>

    <?php
    include_once "footer.php";
    ?>

    </body>
</html>