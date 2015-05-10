<h1>All songs <a href="/songs/upload" class="btn btn-info">
        <i class="glyphicon glyphicon-plus"></i> Upload a song</a></h1>
<div class="row">

<?php foreach ($this->viewbag["songs"] as $song): ?>
    <div class="col-md-4 col-sm-6 song-tiles">
        <div class="col-sm-12">
            <div style="height: 50px">
                <b><?=$song['title']?></b>
            </div>
        </div>
        <div class="col-sm-12 text-center" style="padding-bottom: 10px;">
            <?php if($song['imagename']): ?>
                <img src="/uploads/covers/<?=$song['imagename']?>" style="max-width: 100%; max-height: 100%; min-height: 300px;"/>
            <?php else: ?>
                <img src="/content/img/music.jpg" style="max-width: 100%; max-height: 100%; min-height: 300px;"/>
            <?php endif; ?>

        </div>
        <div class="col-sm-12">
            <audio controls>
                <source src="/uploads/<?=$song['filename']?>" type="audio/mpeg">
              Your browser does not support the audio element.
            </audio>
        </div>
        <div class="col-sm-12"><b>Uploaded by: </b><?=htmlspecialchars($song['username'])?></div>
        <div class="col-sm-12"><b>Genre: </b><?=$song['name']?></div>
        <div class="col-sm-12">
            <form action="/songs/rate/<?=$song['id']?>" method="post" style="display:inline-block">
                <input value="<?=$song['rank']?>" class="rating form-control" data-step="1" data-max="5" data-min="0" data-size="xs"  data-show-caption="false" data-show-clear="false" name="rating-value">
                <input type="hidden" name="redirectTo" value="/songs/mine"/>
            </form>
            <div class="pull-right">
                <form target="_blank" action="/songs/download" method="post" style="display:inline-block">
                    <button class="btn btn-sm btn-info glyphicon glyphicon-download-alt" type="submit" value="download" name="action"></button>
                    <input type="hidden" value="uploads/<?=$song['filename']?>" name="filename"  >
                    <input type="hidden" value="<?=$song['title']?>.mp3" name="filetitle" />
                </form>
                <a href="/songs/comments/<?=$song['id']?>" class="btn btn-sm btn-info glyphicon glyphicon-comment"></a>
                <button class="btn btn-sm btn-info glyphicon glyphicon-plus"></button>
            </div>
        </div>
        <div class="col-sm-12">
            (voted: <?=$song['votes']?> )
        </div>
    </div>
<?php endforeach; ?>
</div>