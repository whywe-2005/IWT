<?php
include('db_config.php');

// Handle RSVP submission
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO rsvp (name,email,phone,message) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss",$name,$email,$phone,$message);
    $stmt->execute();
    $stmt->close();
    $success = "RSVP Submitted Successfully!";
}

// Fetch total guests
$result = $conn->query("SELECT COUNT(*) as total FROM rsvp");
$row = $result->fetch_assoc();
$totalGuests = $row['total'];

// Handle feedback submission
if(isset($_POST['feedback_submit'])){
    $fname = $_POST['fname'];
    $fmessage = $_POST['fmessage'];

    $stmt = $conn->prepare("INSERT INTO feedback (name,message) VALUES (?,?)");
    $stmt->bind_param("ss",$fname,$fmessage);
    $stmt->execute();
    $stmt->close();
    $feedback_success = "Message sent!";
}

// Fetch feedback messages
$feedbackResult = $conn->query("SELECT * FROM feedback ORDER BY time DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Invitation</title>
    <style>
        body { font-family: Arial; background:#f2f2f2; margin:0; padding:0; }
        h2,h3 { text-align:center; color: #b8860b; }
        .container { width:90%; max-width:1000px; margin:auto; }
        input, textarea { width:100%; padding:10px; margin:5px 0; border-radius:10px; border:1px solid gold; }
        button { padding:10px; background:gold; border:none; border-radius:10px; cursor:pointer; font-weight:bold; box-shadow:0 0 10px #ffd700; }
        button:hover { background:orange; }
        .card { background: linear-gradient(135deg, #fff3e0, #ffe082); padding:20px; border-radius:20px; box-shadow:0 0 20px gold; margin:20px 0; }
        #guestCount { font-weight:bold; }
        @keyframes glow { from { text-shadow:0 0 10px #ffd700,0 0 20px #ffd700; } to { text-shadow:0 0 20px #ffea00,0 0 30px #ffea00; } }
        .feedback { background:#fff3e0; padding:15px; border-radius:15px; margin-bottom:10px; box-shadow:0 0 10px gold; }
    </style>
</head>
<body>

<div class="container">

    <!-- Guest Counter -->
    <div style="text-align:center; margin:20px 0;">
        <h2 style="font-size:30px; color: gold; text-shadow: 0 0 10px #093ed1ff,0 0 20px #00ff62ff; animation: glow 1.5s infinite alternate;">
            🎉 Total Guests Attending: <span id="guestCount">0</span>
        </h2>
    </div>

    <!-- Countdown Timer -->
    <div style="text-align:center; margin:20px 0;">
        <h2 style="font-size:28px; color: gold; text-shadow: 0 0 5px #11d34bff,0 0 10px #141413ff;">
            🕒 Event Countdown: <span id="countdown"></span>
        </h2>
    </div>

    <!-- RSVP Form with Heading and Address -->
    <div class="card">
        <h2 style="text-align:center; color:gold; text-shadow:0 0 10px #3b10d6ff;">You're Invited! 🎉</h2>
        <h3 style="text-align:center; color:gold; text-shadow: 0 0 5px #dad8d1ff,0 0 10px #080808ff;">
            Event Location: 123 Celebration Street, GANDHINAGAR,GUJARAT
        </h3>

        <h3>RSVP Form</h3>
        <?php if(isset($success)) echo "<p style='color:green;text-align:center;'>$success</p>"; ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone">
            <textarea name="message" placeholder="Message"></textarea>
            <button type="submit" name="submit">Submit RSVP</button>
        </form>
    </div>

    <!-- Feedback Section -->
    <div class="card">
        <h3>Send Feedback / Wishes</h3>
        <?php if(isset($feedback_success)) echo "<p style='color:green;text-align:center;'>$feedback_success</p>"; ?>
        <form method="POST">
            <input type="text" name="fname" placeholder="Your Name" required>
            <textarea name="fmessage" placeholder="Your Message" required></textarea>
            <button type="submit" name="feedback_submit">Send</button>
        </form>
        <h3>Messages</h3>
        <?php while($f = $feedbackResult->fetch_assoc()){ ?>
            <div class="feedback">
                <strong><?php echo htmlspecialchars($f['name']); ?>:</strong> <?php echo htmlspecialchars($f['message']); ?>
            </div>
        <?php } ?>
    </div>

</div>

<!-- Background Music -->
<audio id="bgMusic" loop autoplay>
    <source src="assets/music.mp3" type="audio/mpeg">
</audio>

<!-- Mute/Play Button -->
<button onclick="toggleMusic()" id="musicBtn" style="
    position:fixed; bottom:20px; right:20px; 
    padding:10px 15px; background:gold; color:#000; 
    border:none; border-radius:50px; cursor:pointer;
    box-shadow:0 0 10px gold;
">🔊</button>

<script>
var music = document.getElementById('bgMusic');
var btn = document.getElementById('musicBtn');
function toggleMusic(){
    if(music.paused){
        music.play();
        btn.innerHTML='🔊';
    } else {
        music.pause();
        btn.innerHTML='🔇';
    }
}

// Guest Counter Animation
var count = <?php echo $totalGuests; ?>;
var displayed = 0;
var interval = setInterval(function(){
    if(displayed < count){
        displayed++;
        document.getElementById('guestCount').innerText = displayed;
    } else { clearInterval(interval); }
}, 50);

// Countdown Timer
var eventDate = new Date("Nov 30, 2025 18:00:00").getTime();
var countdownEl = document.getElementById('countdown');
setInterval(function(){
    var now = new Date().getTime();
    var distance = eventDate - now;
    var days = Math.floor(distance / (1000*60*60*24));
    var hours = Math.floor((distance%(1000*60*60*24))/(1000*60*60));
    var minutes = Math.floor((distance%(1000*60*60))/(1000*60));
    var seconds = Math.floor((distance%(1000*60))/1000);
    countdownEl.innerHTML = days+"d "+hours+"h "+minutes+"m "+seconds+"s";
},1000);
</script>

</body>
</html>