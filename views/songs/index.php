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
        <td>D U D</td>
    </tr>
<?php endforeach; ?>
</table>