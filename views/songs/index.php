<h1>All songs</h1>
<div class="row">
<?php foreach ($this->viewbag["songs"] as $song): ?>
    <div class="col-md-4 col-sm-6 song-tiles">
        <div class="col-sm-12">
            <div style="height: 50px">
                <b><?=$song['title']?></b>
            </div>
        </div>
        <div class="col-sm-12 text-center" style="padding-bottom: 10px;">
            <img src="/uploads/covers/<?=$song['imagename']?>" style="max-width: 100%; max-height: 100%; min-height: 300px;"/></b>
        </div>
        <div class="col-sm-12">
            <audio controls>
                <source src="/uploads/<?=$song['filename']?>" type="audio/mpeg">
              Your browser does not support the audio element.
            </audio>
        </div>
        <div class="col-sm-12"><b>By user: </b><?=$song['username']?></div>
        <div class="col-sm-12"><b>Genre: </b><?=$song['name']?></div>
        <div class="col-sm-12">
            <form action="/songs/rate/<?=$song['id']?>" method="post" style="display:inline-block">
                <input value="<?=$song['rank']?>" class="rating form-control" data-step="1" data-max="5" data-min="0" data-size="xs"  data-show-caption="false" data-show-clear="false" name="rating-value">
            </form> / <?=$song['votes']?>
            <div class="pull-right">
                <form target="_blank" action="/songs/download" method="post" style="display:inline-block">
                    <button class="btn btn-sm btn-info glyphicon glyphicon-download-alt" type="submit" value="download" name="action"></button>
                    <input type="hidden" value="uploads/<?=$song['filename']?>" name="filename"  >
                    <input type="hidden" value="<?=$song['title']?>.mp3" name="filetitle" />
                </form>
                <button class="btn btn-sm btn-info glyphicon glyphicon-comment"></button>
                <button class="btn btn-sm btn-info glyphicon glyphicon-plus"></button>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>