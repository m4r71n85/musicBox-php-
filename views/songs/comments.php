<pre>
    <?php $song = $this->viewbag['song'];
    var_dump($this->viewbag['comments']);
        
    ?>
</pre>  
<div class="row">
    <div class="col-md-4 col-sm-6">
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
        <div class="col-sm-12"><b>Uploaded by: </b><?=$song['username']?></div>
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
                <a href="/songs/comments/<?=$song['id']?>" class="btn btn-sm btn-info glyphicon glyphicon-comment"></a>
                <button class="btn btn-sm btn-info glyphicon glyphicon-plus"></button>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <?php if(!$this->viewbag['comments']): ?>
            <div class="well">Oops. There are no comments yet.</div>
        <?php endif; ?>
            <?php foreach ($this->viewbag['comments'] as $comment): ?>
                <div class="well">
                    <div style="font-weight: bold"><?=$comment['username']?></div>
                    <?=$comment['text']?>
                    <div class="text-muted" ><?=$comment['date_created']?></div>
                </div>
            <?php endforeach; ?>
        <form method="post">
            <textarea class="form-control" name="comment"></textarea>
            <button type="submit" class="btn btn-default btn-info pull-right">Comment</button>
        </div>
    </div>
</div>