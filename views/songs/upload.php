<h1>Upload new song!</h1>

<form action="/songs/upload" method="POST" enctype="multipart/form-data">
    <label for="song">Song: </label>
    <input type="file" name="song" id="song"/><br/>
    <label for="song">Tags: </label>
    
    
    <label for="genre">Genre: </label>
    <select name="genre" id="genre">
        <?php foreach ($this->viewbag["genres"] as $genre):?>
        
        <option value="<?=$genre["id"]?>"><?=$genre["name"]?></option>
        <?php endforeach; ?>
    </select>
    <input type="submit" name="submit" value="Upload" />
</form>