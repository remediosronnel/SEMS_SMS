<?php

$college_courses = array(
    'CA' => array('BSA', 'BSAnsci', 'BSAT', 'BSAgrib', 'BSAgro', 'DIFT'),
    'CAS' => array('BAEL', 'BSAM', 'BSB', 'BSES'),
    'CEIT' => array('BSABE', 'BSCE', 'BSEE'),
    'CCIS' => array('BSIT', 'BSIS', 'BIT'),
    'CTE' => array('BEEd', 'BSEd', 'BTLE'),
    'CBA'=> array('BS Entrep'),
    'GRAD' => array('MSA', 'MSAS', 'MSHort', 'MSABE'),
);

$selected_college = $_GET['college'];


if (array_key_exists($selected_college, $college_courses)) {
   
    foreach ($college_courses[$selected_college] as $courses) {
        echo "<option value='$courses'>$courses </option>";
    }
} else {
    
    echo "<option value=''>Select Course</option>";
}
?>
