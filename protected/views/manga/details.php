<?php $status = Status::model()->findAll(); ?>
<!-- Page Heading -->
<div class="row">
    <h3 class="page-header">
            <?php echo $manga->title; ?> - <small><?php echo 'E'.$manga->episode;?></small> -
            <label class="label label-<?php echo Status::model()->findByPk($manga->status)->css; ?>"><?php echo Status::model()->findByPk($manga->status)->description;?></label>
    </h3>
    <div class="col-md-4">
        <img src="/ressources/upload/images/mangas/<?php echo $manga->image; ?>" alt="<?php echo $manga->title; ?>">
    </div>
    <div class="col-md-8">
        <div class="panel panel-info ">
            <div class="panel-heading">
                <b>Id de la série : <?php echo $manga->id; ?></b>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="/index.php/manga/update" role="form">
                    <input type="text" style="display:none;" name="idManga" id="inputEpisode" value="<?php echo $manga->id; ?>">
                    <div class="form-group">
                        <label for="inputTitle" class="col-sm-3 control-label">Title : </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="inputTitle" id="inputTitle" value="<?php echo $manga->title; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEpisode" class="col-sm-3 control-label">Episode : </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="inputEpisode" id="inputEpisode" value="<?php echo $manga->episode; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="selectStatus" class="col-sm-3 control-label">Status : </label>
                        <div class="col-sm-9">
                            <select id="selectStatus" name="selectStatus" class="form-control">
                                <?php foreach($status as $statu) { ?>
                                <?php 
                                    if($statu->id == $manga->status) {
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
                            <input type="text" class="form-control" name="inputWikipedia" id="inputWikipedia" value="<?php echo $manga->wikiLink; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputStream" class="col-sm-3 control-label">Streaming :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="inputStream" id="inputStream" value="">
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
                            <a href="/index.php/manga" class="btn btn-default">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->