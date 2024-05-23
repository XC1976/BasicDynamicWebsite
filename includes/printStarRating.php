<?php
function printStarRating($rating) {
    if ($rating < 1 || $rating > 5) {
        echo "Invalid rating" . $rating;
        return;
    }
    
    // Calculate the number of filled stars
    $filledStars = floor($rating);
    
    // Check if there's a half-filled star
    if ($rating - $filledStars >= 0.5)  {
        $hasHalfStar = true;
    }
    else {
        $hasHalfStar = false;
    }
    
    // Output filled stars
    for ($i = 0; $i < $filledStars; $i++) {
        echo '<i class="fas fa-star"></i>';
    }
    
    // Output half-filled star if necessary
    if ($hasHalfStar) {
        echo '<i class="fas fa-star-half-alt"></i>';
        $filledStars++; // Increment filled stars count
    }
    
    // Output remaining empty stars
    $emptyStars = 5 - $filledStars;
    for ($i = 0; $i < $emptyStars; $i++) {
        echo '<i class="far fa-star"></i>';
    }
}