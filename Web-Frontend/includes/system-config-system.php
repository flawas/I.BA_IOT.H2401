
<h2>System</h2>
<form method='POST' action="includes/system-config-system-function.php" >
  <div class="form-group">
  <div class="form-check">
    <input type="checkbox" class="form-check-input" id="logEnabled" name="logEnabled" <?php if(getConfig('LogEnabled') == 1){echo "checked"; };?>>
    <label class="form-check-label" for="logEnabled" >Logdatei an / aus</label>
  </div>

  <br>
  <div class="form-group">
    <button type="submit" class="btn btn-outline-primary">Speichern</button>
  </div>
</div>
  
</form>

<script>
function setValue(){
  if(document.getElementById("logEnabled").value == 1) {
    document.getElementById("logEnabled").value = 1;
  } 
  if(document.getElementById("logEnabled").value == 0) {
    document.getElementById("logEnabled").value = 1;
  } 
}
</script>