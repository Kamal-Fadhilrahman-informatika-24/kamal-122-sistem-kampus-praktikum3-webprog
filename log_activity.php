<?php
function logActivity($pdo, $user, $activity) {
    $stmt = $pdo->prepare("INSERT INTO activity_logs (user, activity) VALUES (?, ?)");
    $stmt->execute([$user, $activity]);
}
?>