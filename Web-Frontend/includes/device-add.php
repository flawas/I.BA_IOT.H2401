<h1>Senor hinzufügen</h1>
<form method='POST' action='includes/device-add-function.php'>
  <div class="form-group">
    <label for="endDeviceID" class="form-text">End device ID</label>
    <input type="text" class="form-control" id="endDeviceID" placeholder="eui-a8404181f186a539" name="endDeviceID">
  </div>
  <div class="form-group">
    <label for="endDevicePlace" class="form-text">Sensor Ort</label>
    <input type="text" class="form-control" id="endDevicePlace" placeholder="Blauweidweg, Waschküche" name="endDevicePlace">
  </div>
  <div class="form-group">
    <label for="endDeviceType" class="form-text">Senor Typ</label>
    <input type="text" class="form-control" id="endDeviceType" placeholder="Temperatursensor" name="endDeviceType">
  </div>
  <div class="form-group">
    <label for="endDeviceManufacturer" class="form-text">Sensor Marke</label>
    <input type="text" class="form-control" id="endDeviceManufacturer" placeholder="dragino" name="endDeviceManufacturer">
  </div>
  <div class="form-group">
    <label for="endDeviceModel" class="form-text">Sensor Modell</label>
    <input type="text" class="form-control" id="endDeviceModel" placeholder="lht65" name="endDeviceModel">
  </div>
  <div class="form-group">
    <label for="endDeviceModelValue1" class="form-text">Sensor Wert 1 Wert</label>
    <input type="text" class="form-control" id="endDeviceModelValue1" placeholder="Grad Celsius" name="endDeviceModelValue1">
  </div>
  <div class="form-group">
    <label for="endDeviceModelValueName1" class="form-text">Sensor Wert 1 Name</label>
    <input type="text" class="form-control" id="endDeviceModelValueName1" placeholder="Temperatur" name="endDeviceModelValueName1">
  </div>

  <div class="form-group">
    <label for="endDeviceModelValue2" class="form-text">Sensor Wert 2 Wert</label>
    <input type="text" class="form-control" id="endDeviceModelValue2" placeholder="Grad Celsius" name="endDeviceModelValue2">
  </div>
  <div class="form-group">
    <label for="endDeviceModelValueName2" class="form-text">Sensor Wert 2 Name</label>
    <input type="text" class="form-control" id="endDeviceModelValueName2" placeholder="Temperatur" name="endDeviceModelValueName2">
  </div>

  <div class="form-group">
    <label for="endDeviceModelValue3" class="form-text">Sensor Wert 3 Wert</label>
    <input type="text" class="form-control" id="endDeviceModelValue3" placeholder="Grad Celsius" name="endDeviceModelValue3">
  </div>
  <div class="form-group">
    <label for="endDeviceModelValueName3" class="form-text">Sensor Wert 3 Name</label>
    <input type="text" class="form-control" id="endDeviceModelValueName3" placeholder="Temperatur" name="endDeviceModelValueName3">
  </div>
  <br>
  <div class="form-group">
    <button type="submit" class="btn btn-outline-primary">Sensor erstellen</button>
  </div>
  
</form>