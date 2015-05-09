<h1>Upload new song!</h1>
<div class="row">
    <form action="/songs/upload" method="POST" enctype="multipart/form-data" class="col-sm-6 col-md-5">
        
        <label for="song">Song file (mp3): </label>
        <input type="file" name="song" id="song" class="form-control"><br/>
        
        <label for="image">Cover image: </label>
        <input type="file" name="image" id="image" class="form-control"><br/>
        
        <label for="genre">Genre: </label>
        <select name="genre" id="genre" class="form-control">
            <?php foreach ($this->viewbag["genres"] as $genre):?>
            <option value="<?=$genre["id"]?>"><?=$genre["name"]?></option>
            <?php endforeach; ?>
        </select><br/>
        
        <input type="submit" name="submit" value="Upload" class="btn btn-info"/>
</form>
</div>