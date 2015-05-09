<h1>All songs</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Title</th>
            <th>Play</th>    
            <th>Uploader</th>
            <th>Genre</th>
            <th>Rating</th>
            <th>Votes</th>
            <th></th>
        </tr>
    </thead>
<?php foreach ($this->viewbag["songs"] as $song): ?>
    <tr>
        <td><?=$song['title']?></td>
        <td>
            <audio controls>
                <source src="/uploads/<?=$song['filename']?>" type="audio/mpeg">
              Your browser does not support the audio element.
              </audio>
        </td>
        <td><?=$song['username']?></td>
        <td><?=$song['name']?></td>
        <td><?=$song['rank']?></td>
        <td><?=$song['votes']?></td>
        <td>
                <form action="songs/controls/<?=$song['id']?>" method="post" style="display:inline-block">
                    <button class="btn btn-sm btn-success glyphicon glyphicon-thumbs-up" type="submit" value="like" name="action"></button>
                    <button class="btn btn-sm btn-danger glyphicon glyphicon-thumbs-down" type="submit" value="dislike" name="action"></button>
                </form>
                <form target="_blank" action="songs/download" method="post" style="display:inline-block">
                    <input type="hidden" value="uploads/<?=$song['filename']?>" name="filename"  >
                    <input type="hidden" value="<?=$song['title']?>.mp3" name="filetitle" />
                    <button class="btn btn-sm btn-info glyphicon glyphicon-download-alt" type="submit" value="download" name="action"></button>
                </form>
        </td>
    </tr>
<?php endforeach; ?>
</table>