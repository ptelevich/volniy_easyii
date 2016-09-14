<form action="<?= Yii::$app->urlManager->createUrl(['vk/download-audio'])?>" method="POST" id="downloadForm">
    <input type="hidden" name="audioUrl" />
</form>
<?php foreach ($response['response'] as $r):  ?>
    <?php if (!empty($r['title'])): ?>
        <hr />
        <?= $r['artist'] . ' - ' . $r['title'] ?>
        <span
            data-aid="<?= $r['aid'] ?>"
            style="color: lightskyblue; cursor: pointer;"
            class="download"
        >
            Download
        </span>
        <span
            data-aid-url="<?= $r['aid'] ?>"
            style="display: none;"
        ><?= $r['url'] ?></span>
        <?php endif; ?>
<?php endforeach; ?>
<script>
    $(function(){
        $('.download').on('click', function(){
            var getUrl = $('span[data-aid-url="' + $(this).data('aid')+ '"]').text();
            $('#downloadForm input').attr('value', getUrl);
            $('#downloadForm').submit();
        });
    })
</script>