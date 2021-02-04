<div class="form-popup" id="myForm">
    <link rel="stylesheet" scr="popup.css">
    <form action="/action_page.php" class="form-container">
        <h1>Update</h1>

        <label for="email"><b>Email</b></label>
        <input type="text" placeholder="Enter Email" name="email" required>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw" required>

        <button type="submit" class="btn">Login</button>
        <button type="submit" class="btn cancel" onclick="closeForm()">Close</button>
    </form>
</div>


<script>
        function openForm() {
            document.getElementById("myForm").style.display = "block";
        }

        function closeForm() {
            document.getElementById("myForm").style.display = "none";
        }
</script>