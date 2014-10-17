<?php $status = Status::model()->findAll(); ?>
<!-- Page Heading -->
<div class="row">
    <h3 class="page-header">
            <?php echo $serie->title; ?> - <small><?php echo 'S'.$serie->season.' E'.$serie->episode;?></small> -
            <label class="label label-<?php echo Status::model()->findByPk($serie->status)->css; ?>"><?php echo Status::model()->findByPk($serie->status)->description;?></label>
    </h3>
    <div class="col-md-4">
        <img src="/ressources/upload/images/series/<?php echo $serie->image; ?>" alt="<?php echo $serie->title; ?>">
    </div>
    <div class="col-md-8">
        <div class="panel panel-info ">
            <div class="panel-heading">
                <b>Id de la série : <?php echo $serie->id; ?></b>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="/index.php/serie/update" role="form">
                    <input type="text" style="display:none;" name="idSerie" id="inputEpisode" value="<?php echo $serie->id; ?>">
                    <div class="form-group">
                        <label for="inputTitle" class="col-sm-3 control-label">Title : </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="inputTitle" id="inputTitle" value="<?php echo $serie->title; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSeason" class="col-sm-3 control-label">Season : </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="inputSeason" id="inputSeason" value="<?php echo $serie->season; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEpisode" class="col-sm-3 control-label">Episode : </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="inputEpisode" id="inputEpisode" value="<?php echo $serie->episode; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="selectStatus" class="col-sm-3 control-label">Status : </label>
                        <div class="col-sm-9">
                            <select id="selectStatus" name="selectStatus" class="form-control">
                                <?php foreach($status as $statu) { ?>
                                <?php 
                                    if($statu->id == $serie->status) {
                                        $selected = 'selected';
                                    } else {
                                        $selected = '';
                                    }
                                ?>
                                    <option class="bg-<?php echo $statu->css; ?>" 
                                            value="<?php echo $statu->id; ?>" <?php echo $selected; ?>>
                                                <?php echo $statu->description; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputWikipedia" class="col-sm-3 control-label">&copy; Wikipedia : </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="inputWikipedia" id="inputWikipedia" value="<?php echo $serie->wikiLink; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputTorrent" class="col-sm-3 control-label">&copy; frenchtorrentdb :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="inputTorrent" id="inputTorrent" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="fichier" title="Search image">Image :</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="fichier" type="file" id="fichier">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a href="/index.php/serie" class="btn btn-default">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->