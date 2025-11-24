    <!DOCTYPE html>  
    <html>  
    <head>  
    <style>  
    .error {color: #FF0001;}  
    </style>  
    </head>  
    <body>    
      
    <?php  
    // define variables to empty values  
    $nameErr = $emailErr = $mobilenoErr = $genderErr = $websiteErr = $agreeErr = "";  
    $name = $email = $mobileno = $gender = $website = $agree = "";  
      
    //Input fields validation  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {  
          
    //String Validation  
        if (empty($_POST["name"])) {  
             $nameErr = "Le nom est requis";  
        } else {  
            $name = input_data($_POST["name"]);  
                // check if name only contains letters and whitespace  
                if (!preg_match("/^[a-zA-Z ]*$/",$name)) {  
                    $nameErr = "Uniquement les lettres de l'alphabet et les espaces sont autorisés";  
                } 
        }  
          
        //Email Validation   
        if (empty($_POST["email"])) {  
                $emailErr = "L'email est requis";  
        } else {  
                $email = input_data($_POST["email"]);  
                // check that the e-mail address is well-formed  
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
                    $emailErr = "Le format de l'adresse email est invalide'";  
                }  
         }  
        
        //Number Validation  
        if (empty($_POST["mobileno"])) {  
                $mobilenoErr = "Le numéro de portable est requis";  
        } else {  
                $mobileno = input_data($_POST["mobileno"]);  
                // check if mobile no is well-formed, including space  
                if (!preg_match ("/^([0-9])*$/", $mobileno) ) {  
                $mobilenoErr = "Seule les valeurs numériques sont acceptée.";  
                }  
            //check mobile no length should not be less and greator than 10  
            if (strlen ($mobileno) != 10) {  
                $mobilenoErr = "Le numéro de portable doit contenir 10 chiffres.";  
                }  
        }  
          
        //URL Validation      
        if (empty($_POST["website"])) {  
            $website = "";  
        } else {  
                $website = input_data($_POST["website"]);  
                // check if URL address syntax is valid  
                if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {  
                    $websiteErr = "l'URL est invalide";  
                }      
        }  
          
        //Empty Field Validation  
        if (empty ($_POST["gender"])) {  
                $genderErr = "Le sexe est requis";  
        } else {  
                $gender = input_data($_POST["gender"]);  
        }  
      
        //Checkbox Validation  
        if (!isset($_POST['agree'])){  
                $agreeErr = "Accepter les conditions d'utilisation avant d'envoyer'.";  
        } else {  
                $agree = input_data($_POST["agree"]);  
        }  
    }  
    function input_data($data) {  
      $data = trim($data);  
      $data = stripslashes($data);  
      $data = htmlspecialchars($data);  
      return $data;  
    }  
    ?>  
      
    <h2>Formulaire de Souscription'</h2>  
    <span class = "error">* champs requis </span>  
    <br><br>  
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >    
        Nom:   
        <input type="text" name="name">  
        <span class="error">* <?php echo $nameErr; ?> </span>  
        <br><br>  
        E-mail:   
        <input type="text" name="email">  
        <span class="error">* <?php echo $emailErr; ?> </span>  
        <br><br>  
        Numéro de Téléphone Portable:   
        <input type="text" name="mobileno">  
        <span class="error">* <?php echo $mobilenoErr; ?> </span>  
        <br><br>  
        Site Internet:   
        <input type="text" name="website">  
        <span class="error"><?php echo $websiteErr; ?> </span>  
        <br><br>  
        Sexe:  
        <input type="radio" name="gender" value="male"> Masculin  
        <input type="radio" name="gender" value="female"> Féminin  
        <input type="radio" name="gender" value="other"> Autre
        <span class="error">* <?php echo $genderErr; ?> </span>  
        <br><br>  
        Accepter les conditions d'utilisation:  
        <input type="checkbox" name="agree">  
        <span class="error">* <?php echo $agreeErr; ?> </span>  
        <br><br>                            
        <input type="submit" name="submit" value="Envoyer">   
        <br><br>                             
    </form>  
      
    <?php  
        if(isset($_POST['submit'])) {  
        if($nameErr == "" && $emailErr == "" && $mobilenoErr == "" && $genderErr == "" && $websiteErr == "" && $agreeErr == "") {  
            echo "<h3 color = #FF0001> <b>Vous avez souscrit avec succès.</b> </h3>";  
            echo "<h2>Your Input:</h2>";  
            echo "Name: " .$name;  
            echo "<br>";  
            echo "Email: " .$email;  
            echo "<br>";  
            echo "Mobile No: " .$mobileno;  
            echo "<br>";  
            echo "Website: " .$website;  
            echo "<br>";  
            echo "Gender: " .$gender;  
        } else {  
            echo "<h3> <b>Vous n'avez pas rempli le formulaire correctement'.</b> </h3>";  
        }  
        }  
    ?>  
      
    </body>  
    </html>  
