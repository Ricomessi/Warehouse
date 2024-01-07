<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include("koneksi.php");

// Fetch user data based on the session information
$username = $_SESSION['username'];
$selectQuery = "SELECT * FROM pengguna WHERE username = ?";
$stmt = $koneksi->prepare($selectQuery);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Check if user data is available
if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    // Handle the case where user data is not found (optional)
    $userData = array(); // You can set it to an empty array or handle it as needed
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-300">

    <!-- Navigation -->
    <!-- Include your navigation bar here if needed -->

    <!-- Content -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-4xl text-center">Edit Profile</h1>
                    </div>
                    <div class="card-body">
                        <form action="prosesUpdateProfile.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="newusername" class="form-label">Username:</label>
                                <input type="text" name="newusername" class="form-control"
                                    value="<?php echo isset($userData['username']) ? htmlspecialchars($userData['username']) : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" name="email" class="form-control"
                                    value="<?php echo isset($userData['email']) ? htmlspecialchars($userData['email']) : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                                <?php
                                    // Retrieve the updated profile image name from the database for the logged-in user
                                    $selectImageQuery = "SELECT profile FROM pengguna WHERE username = ?";
                                    $stmt = $koneksi->prepare($selectImageQuery);
                                    $stmt->bind_param("s", $_SESSION['username']);
                                    $stmt->execute();
                                    $stmt->bind_result($profileImage);
                                    $stmt->fetch();
                                    $stmt->close();
                                    if (!empty($profileImage)) {
                                        echo '<img src="uploads/' . $profileImage . '" alt="Profile Picture" class="mt-2" style="width: 100px; height: 100px; object-fit: cover;">';
                                    }
                                    ?>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <!-- Include your footer here if needed -->

</body>

</html>