<br><br>
<div class="gender-selector">
    <form method="post">
        <h3>What is your gender?</h3>
        <input type="radio" id="male" name="gender" value="male"
            <?php if (isset($_POST['gender']) && $_POST['gender'] === 'male'): ?>
               checked="checked"> <?php endif; ?>
        <label for="male">Male</label>
        <input type="radio" id="female" name="gender" value="female"
            <?php if (isset($_POST['gender']) && $_POST['gender'] === 'female'): ?>
               checked="checked"><?php endif; ?>
        <label for="female">Female</label>
        <input type="submit" value="Submit" class="button">
    </form>
</div>