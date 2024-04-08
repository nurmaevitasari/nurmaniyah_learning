<?php 
  
// Function to generate OTP 
function generateNumericOTP($n) { 
      
    $generator = "1357902468"; 
  
    $result= ""; 
    for ($i = 1; $i <= $n; $i++) { 
        $result .= substr($generator, (rand()%(strlen($generator))), 1); 
    } 
  
    return $result; 
} 
  
// Main program 
$n = 4; 
print_r(generateNumericOTP($n)); 
echo ("\n");
?>
