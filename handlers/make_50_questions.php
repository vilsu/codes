<?php
// Go through each question in the first array
foreach($array1 as $id => $sub_array)
{
    // Grab the title for the first array
    $title = $sub_array['title'];

    // Grab the tags for the question from the second array
    $tags = $array2[$id]['tags'];

    // 1.1 Print the Title & 1.2 Print the Tags
    create_question($title);
}

// Functions

// Create all the parts of a question.
function create_question($title, $tags)
{
    create_title($title);
    create_tags($tags);
}

// Print the Title
function create_title($title)
{
    echo $title;
}

// Loop Through Each Tag and Print it
function create_tags($tags)
{
    echo "<ul>";
    foreach($tags as $tag)
    {
        echo "<li>".$tag."</li>";
    }
    echo "</ul>";
}

?>
