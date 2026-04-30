<?php 
include '../includes/db.php'; 

if (isset($_POST['btn_delete'])) {
    $id = $_POST['d_id'];
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php?status=deleted");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf8mb4">
    <title>Student Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <img src="../images/luffy.png" id="logo" onclick="hideAllContent()">
        <button class="navbarbuttons" onclick="showSection('create')"> Create </button>
        <button class="navbarbuttons" onclick="showSection('read')"> Read </button>
        <button class="navbarbuttons" onclick="showSection('update')"> Update </button>
        <button class="navbarbuttons" onclick="showSection('delete')"> Delete </button>
    </nav>

    <section id="home" class="homecontent"> 
        <h1 class="splash">Welcome to Student Management System</h1>
        <h2 class="splash">A Project in Integrative Programming Technologies</h2>
    </section>
    
    <section id="create" class="content">
        <h1 class="contenttitle"> Insert New Student </h1>
        <form action="../includes/insert.php" method="POST">
            <label class="label">Surname</label><input type="text" name="surname" class="field" required><br/>
            <label class="label">Name</label><input type="text" name="name" class="field" required><br/>
            <label class="label">Middle name</label><input type="text" name="middlename" class="field"><br/>
            <label class="label">Address</label><input type="text" name="address" class="field"><br/>
            <label class="label">Mobile</label><input type="text" name="contact" class="field"><br/>
            <div id="btncontainer">
                <button type="button" class="btns" onclick="clearFields()">Clear Fields</button>
                <button type="submit" class="btns">Save</button>
            </div>
        </form>   
    </section>

    <section id="read" class="content"> 
        <h1 class="contenttitle">View Students</h1>
        <table>
            <thead>
                <tr><th>ID</th><th>Surname</th><th>Name</th><th>Address</th><th>Contact</th></tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM students");
                while($row = $stmt->fetch()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['surname']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['contact_number']}</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <section id="update" class="content"> 
        <h1 class="contenttitle">Update Records</h1>
        <form method="GET">
            <label class="label">Enter Student ID:</label>
            <input type="number" name="search_u" class="field" required>
            <button type="submit" class="btns" style="width:80px;">Search</button>
        </form>
        
        <?php if(isset($_GET['search_u'])): 
            $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
            $stmt->execute([$_GET['search_u']]);
            if($row = $stmt->fetch()): ?>
                <form action="../includes/test.php" method="POST" style="margin-top:20px;">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <table>
                        <tr><th>Field</th><th>Update Information</th></tr>
                        <tr><td>Middlename</td><td><input type="text" name="middlename" class="field" value="<?= $row['middlename'] ?>"></td></tr>
                        <tr><td>Surname</td><td><input type="text" name="surname" class="field" value="<?= $row['surname'] ?>"></td></tr>
                        <tr><td>Name</td><td><input type="text" name="name" class="field" value="<?= $row['name'] ?>"></td></tr>
                        <tr><td>Address</td><td><input type="text" name="address" class="field" value="<?= $row['address'] ?>"></td></tr>
                        <tr><td>Contact</td><td><input type="text" name="contact" class="field" value="<?= $row['contact_number'] ?>"></td></tr>
                    </table>
                    <button type="submit" name="btn_update" class="btns">Update Record</button>
                </form>
            <?php else: echo "<p style='color:red;'>Student ID not found.</p>"; endif; 
        endif; ?>
    </section>

    <section id="delete" class="content"> 
        <h1 class="contenttitle">Remove Records</h1>
        <form method="GET">
            <label class="label">Enter Student ID:</label>
            <input type="number" name="search_d" class="field" required>
            <button type="submit" class="btns" style="width:80px;">Search</button>
        </form>

        <?php if(isset($_GET['search_d'])): 
            $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
            $stmt->execute([$_GET['search_d']]);
            if($row = $stmt->fetch()): ?>
                <div style="margin-top:20px;">
                    <table>
                        <tr><th>ID</th><th>Surname</th><th>Name</th><th>Middle Name</th><th>Address</th><th>Contact</th></tr>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['surname'] ?></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['middlename'] ?></td>
                            <td><?= $row['address'] ?></td>
                            <td><?= $row['contact_number'] ?></td>
                        </tr>
                    </table>
                    <form method="POST">
                        <input type="hidden" name="d_id" value="<?= $row['id'] ?>">
                        <button type="submit" name="btn_delete" class="btns" style="background-color: #e74c3c;">Delete Student</button>
                    </form>
                </div>
            <?php else: echo "<p style='color:red;'>Student ID not found.</p>"; endif; 
        endif; ?>
    </section>

    <script src="script.js"></script>
</body>
</html>
