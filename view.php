
<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: admin.php");
    exit;
}

include('db_config.php');

// Delete RSVP
if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];
    $conn->query("DELETE FROM rsvp WHERE id=$id");
    header("Location: view.php");
    exit;
}

// Edit RSVP
if(isset($_POST['edit_submit'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    $conn->query("UPDATE rsvp SET name='$name', email='$email', phone='$phone', message='$message' WHERE id=$id");
    header("Location: view.php");
    exit;
}

// Search RSVPs
$search_query = "";
if(isset($_GET['search'])){
    $search = $conn->real_escape_string($_GET['search']);
    $search_query = " WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR rsvp_time LIKE '%$search%'";
}

$result = $conn->query("SELECT * FROM rsvp $search_query ORDER BY rsvp_time DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - RSVPs</title>
    <style>
        body { font-family: Arial; background:#f5f5f5; margin:0; padding:0; }
        .container { width:90%; margin:auto; padding:20px; background:#fff; border-radius:10px; box-shadow:0 0 10px #aaa; }
        h2 { color: gold; text-align:center; }
        table { width:100%; border-collapse: collapse; }
        table, th, td { border:1px solid #ccc; }
        th, td { padding:10px; text-align:center; }
        input[type=text] { padding:5px; width:200px; }
        button { padding:5px 10px; background:gold; border:none; border-radius:5px; cursor:pointer; }
        button:hover { background:orange; }
    </style>
</head>
<body>
<div class="container">
    <h2>Admin Panel - RSVPs</h2>

    <!-- Search -->
    <form method="GET" style="text-align:center; margin-bottom:20px;">
        <input type="text" name="search" placeholder="Search by name/email/date">
        <button>Search</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Message</th>
            <th>Time</th>
            <th>Action</th>
        </tr>
        <?php while($row = $result->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['message']; ?></td>
            <td><?php echo $row['rsvp_time']; ?></td>
            <td>
                <a href="view.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this entry?')">Delete</a> |
                <a href="#" onclick="editEntry(<?php echo $row['id']; ?>,'<?php echo addslashes($row['name']); ?>','<?php echo addslashes($row['email']); ?>','<?php echo addslashes($row['phone']); ?>','<?php echo addslashes($row['message']); ?>')">Edit</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <!-- Edit Modal -->
    <div id="editModal" style="display:none; position:fixed; top:10%; left:50%; transform:translateX(-50%); background:#fff; padding:20px; border:2px solid gold; border-radius:10px; z-index:1000;">
        <h3>Edit RSVP</h3>
        <form method="POST">
            <input type="hidden" name="id" id="edit_id">
            Name: <input type="text" name="name" id="edit_name" required><br><br>
            Email: <input type="text" name="email" id="edit_email" required><br><br>
            Phone: <input type="text" name="phone" id="edit_phone"><br><br>
            Message: <textarea name="message" id="edit_message"></textarea><br><br>
            <button type="submit" name="edit_submit">Save</button>
            <button type="button" onclick="closeModal()">Cancel</button>
        </form>
    </div>

</div>

<script>
function editEntry(id,name,email,phone,message){
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_phone').value = phone;
    document.getElementById('edit_message').value = message;
    document.getElementById('editModal').style.display = 'block';
}
function closeModal(){
    document.getElementById('editModal').style.display = 'none';
}
</script>

</body>
</html>