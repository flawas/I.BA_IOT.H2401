<h2>Slack</h2>
<form method='POST' action='includes/system-config-slack-function.php'>
  <div class="form-group">
    <div class="form-check">
      <input type="checkbox" class="form-check-input" id="slackEnabled" name="slackEnabled" <?php if(getConfig('LogEnabled') == 1){echo "checked"; };?>>
      <label class="form-check-label" for="slackEnabled" name="slackEnabled">Slack an / aus</label>
    </div>

    <div class="form-group">
      <label for="slackThreesholdTemp">Slack Threeshold Temperatur</label>
      <input type="number" class="form-control" id="slackThreesholdTemp" name="slackThreesholdTemp" value="<?php echo getConfig('SlackThreesholdTemp');?>">
    </div>

    <div class="form-group">
      <label for="slackThreesholdHum">Slack Threeshold Luftfeuchtigkeit</label>
      <input type="number" class="form-control" id="slackThereesholdHum" name="slackThreesholdHum" value="<?php echo getConfig('SlackThreesholdHum');?>">
    </div>

    <br>
    <div class="form-group">
      <button type="submit" class="btn btn-outline-primary">Speichern</button>
    </div>
  </div>
</form>
<script>
function setValue(){
  if(document.getElementById("slackEnabled").value == 1) {
    document.getElementById("slackEnabled").value = 1;
  } 
  if(document.getElementById("slackEnabled").value == 0) {
    document.getElementById("slackEnabled").value = 1;
  } 
}
</script>