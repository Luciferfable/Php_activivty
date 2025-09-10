<?php
$fullName = $userEmail = $userPass = $userGender = $phone = $userAddress = $birthdate = $program = $institute = $gitlink = $linkprofile = $remarks = "";
$interest = "";
$ability = "";

$successNote = "";

$fullNameErr = $userEmailErr = $userPassErr = $userGenderErr = $phoneErr = $userAddressErr = $birthdateErr = $programErr = $instituteErr = $gitlinkErr = $linkprofileErr = $interestErr = $abilityErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["fullName"])) {
        $fullNameErr = "Full name required";
    } else {
        $fullName = $_POST["fullName"];
        for ($i = 0; $i < strlen($fullName); $i++) {
            if ($fullName[$i] >= '0' && $fullName[$i] <= '9') {
                $fullNameErr = "Numbers not allowed in name";
                break;
            }
        }
    }

    if (empty($_POST["userEmail"])) {
        $userEmailErr = "Email required";
    } else {
        $userEmail = $_POST["userEmail"];
        if (strpos($userEmail, "@") === false || strpos($userEmail, ".") === false) {
            $userEmailErr = "Invalid email";
        }
    }

    if (empty($_POST["userPass"])) {
        $userPassErr = "Password required";
    } elseif (strlen($_POST["userPass"]) < 6) {
        $userPassErr = "Min 6 characters needed";
    } else {
        $userPass = $_POST["userPass"];
    }

    if (empty($_POST["userGender"])) {
        $userGenderErr = "Select gender";
    } else {
        $userGender = $_POST["userGender"];
    }

    if (empty($_POST["phone"])) {
        $phoneErr = "Phone required";
    } else {
        $phone = $_POST["phone"];
        $digitsOnly = true;
        for ($i = 0; $i < strlen($phone); $i++) {
            if (!($phone[$i] >= '0' && $phone[$i] <= '9')) {
                $digitsOnly = false;
                break;
            }
        }
        if (!$digitsOnly || strlen($phone) != 10) {
            $phoneErr = "Enter valid 10-digit number";
        }
    }

    if (empty($_POST["userAddress"])) {
        $userAddressErr = "Address required";
    } else {
        $userAddress = $_POST["userAddress"];
    }

    if (empty($_POST["birthdate"])) {
        $birthdateErr = "Birthdate required";
    } else {
        $birthdate = $_POST["birthdate"];
    }

    if (empty($_POST["program"])) {
        $programErr = "Program required";
    } else {
        $program = $_POST["program"];
    }

    if (empty($_POST["institute"])) {
        $instituteErr = "Institute required";
    } else {
        $institute = $_POST["institute"];
    }

    if (empty($_POST["gitlink"])) {
        $gitlinkErr = "GitHub link required";
    } else {
        $gitlink = $_POST["gitlink"];
        if (strpos($gitlink, "http") !== 0) {
            $gitlinkErr = "Invalid GitHub link";
        }
    }

    if (empty($_POST["linkprofile"])) {
        $linkprofileErr = "LinkedIn required";
    } else {
        $linkprofile = $_POST["linkprofile"];
        if (strpos($linkprofile, "http") !== 0) {
            $linkprofileErr = "Invalid LinkedIn link";
        }
    }

    if (empty($_POST["interest"])) {
        $interestErr = "Choose an interest";
    } else {
        $interest = $_POST["interest"];
    }

    if (empty($_POST["ability"])) {
        $abilityErr = "Pick a skill";
    } else {
        $ability = $_POST["ability"];
    }

    if (!empty($_POST["remarks"])) {
        $remarks = $_POST["remarks"];
    }

    if (
        $fullNameErr=="" && $userEmailErr=="" && $userPassErr=="" && $userGenderErr=="" &&
        $phoneErr=="" && $userAddressErr=="" && $birthdateErr=="" && $programErr=="" &&
        $instituteErr=="" && $gitlinkErr=="" && $linkprofileErr=="" && $interestErr=="" && $abilityErr==""
    ) {
        $record = "Name: $fullName\nEmail: $userEmail\nPassword: $userPass\nGender: $userGender\nPhone: $phone\nAddress: $userAddress\nDOB: $birthdate\nProgram: $program\nInstitute: $institute\nGitHub: $gitlink\nLinkedIn: $linkprofile\nInterest: $interest\nSkill: $ability\nRemarks: $remarks\n";
        $record .= "----------------------------------\n";

        $file = fopen("submissions.txt", "a");
        fwrite($file, $record);
        fclose($file);

        $successNote = "<div class='success-box'>Form submitted successfully ✅</div>";

        $_POST = [];
        $fullName = $userEmail = $userPass = $userGender = $phone = $userAddress = $birthdate = $program = $institute = $gitlink = $linkprofile = $remarks = "";
        $interest = "";
        $ability = "";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
    <div class="card shadow p-4" style="max-width:600px;margin:auto;">
        <h2 class="mb-4 text-center">Student Registration</h2>

        <?php if ($successNote != "") echo $successNote; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="fullName" class="form-control" value="<?php echo $fullName; ?>">
                <small class="text-danger"><?php echo $fullNameErr; ?></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" name="userEmail" class="form-control" value="<?php echo $userEmail; ?>">
                <small class="text-danger"><?php echo $userEmailErr; ?></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="userPass" class="form-control">
                <small class="text-danger"><?php echo $userPassErr; ?></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Gender</label>
                <select name="userGender" class="form-select">
                    <option value="">Select</option>
                    <option value="Male" <?php if($userGender=="Male") echo "selected";?>>Male</option>
                    <option value="Female" <?php if($userGender=="Female") echo "selected";?>>Female</option>
                </select>
                <small class="text-danger"><?php echo $userGenderErr; ?></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
                <small class="text-danger"><?php echo $phoneErr; ?></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="userAddress" class="form-control"><?php echo $userAddress; ?></textarea>
                <small class="text-danger"><?php echo $userAddressErr; ?></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Birthdate</label>
                <input type="date" name="birthdate" class="form-control" value="<?php echo $birthdate; ?>">
                <small class="text-danger"><?php echo $birthdateErr; ?></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Program</label>
                <input type="text" name="program" class="form-control" value="<?php echo $program; ?>">
                <small class="text-danger"><?php echo $programErr; ?></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Institute</label>
                <input type="text" name="institute" class="form-control" value="<?php echo $institute; ?>">
                <small class="text-danger"><?php echo $instituteErr; ?></small>
            </div>

            <div class="mb-3">
                <label class="form-label">GitHub</label>
                <input type="text" name="gitlink" class="form-control" value="<?php echo $gitlink; ?>">
                <small class="text-danger"><?php echo $gitlinkErr; ?></small>
            </div>

            <div class="mb-3">
                <label class="form-label">LinkedIn</label>
                <input type="text" name="linkprofile" class="form-control" value="<?php echo $linkprofile; ?>">
                <small class="text-danger"><?php echo $linkprofileErr; ?></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Interest</label><br>
                <input type="radio" name="interest" value="Reading" <?php if($interest=="Reading") echo "checked"; ?>> Reading<br>
                <input type="radio" name="interest" value="Sports" <?php if($interest=="Sports") echo "checked"; ?>> Sports<br>
                <input type="radio" name="interest" value="Music" <?php if($interest=="Music") echo "checked"; ?>> Music<br>
                <input type="radio" name="interest" value="Traveling" <?php if($interest=="Traveling") echo "checked"; ?>> Traveling<br>
                <small class="text-danger"><?php echo $interestErr; ?></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Skill</label><br>
                <input type="radio" name="ability" value="C" <?php if($ability=="C") echo "checked"; ?>> C<br>
                <input type="radio" name="ability" value="C++" <?php if($ability=="C++") echo "checked"; ?>> C++<br>
                <input type="radio" name="ability" value="Java" <?php if($ability=="Java") echo "checked"; ?>> Java<br>
                <input type="radio" name="ability" value="Python" <?php if($ability=="Python") echo "checked"; ?>> Python<br>
                <input type="radio" name="ability" value="PHP" <?php if($ability=="PHP") echo "checked"; ?>> PHP<br>
                <small class="text-danger"><?php echo $abilityErr; ?></small>
            </div>

            <div class="mb-3">
                <label class="form-label">Remarks</label>
                <textarea name="remarks" class="form-control"><?php echo $remarks; ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>
</div>
</body>
</html>
