var express = require('express');
var router = express.Router();

/* GET home page. 
router.get('/', function(req, res, next) {
  res.render('index', { title: 'Express' });
});*/

var monk = require('monk');
var db = monk('localhost:27017/vidzy');


router.get('/', function(req, res, next) {
  res.redirect('/videos');
});

router.get('/videos', function(req, res) {
    var collection = db.get('videos');
    
    var options = [ "All Genre", "Action", "Animation", "Fantasy", "Drama", "Sci-fi" ];
    var search_string = '';
    var genre = 'All Genre';

    search_string = req.query.search;
    genre = req.query.genre;
    var query = {};

    if (search_string != '' && search_string != undefined) {
        query['title'] = new RegExp(search_string, 'i');
    }

    if (genre != 'All Genre' && genre != undefined) {
        query['genre'] = genre;
    }

    collection.find(query, function(err, videos){
        if (err) throw err;
        res.render('index', { videos: videos, search: search_string, genre: genre, options: options });
    });
});


//new video
router.get('/videos/new', function(req, res) {
    res.render('new');
});


//insert route
router.post('/videos', function(req, res){
    var collection = db.get('videos');
    collection.insert({
        title: req.body.title,
        genre: req.body.genre,
        image: req.body.image,
        description: req.body.desc
    }, function(err, video){
        if (err) throw err;

        res.redirect('/videos');
    });
});

router.get('/videos/:id', function(req, res) {
    var collection = db.get('videos');
    collection.findOne({ _id: req.params.id }, function(err, video){
        if (err) throw err;
        //res.json(video);
        res.render('show', { video: video });
    });
});

//delete route
router.delete('/videos/:id', function(req, res){
    var collection = db.get('videos');
    collection.remove({ _id: req.params.id }, function(err, video){
        if (err) throw err;

        res.redirect('/');
    });
});

//edit video
router.get('/videos/:id/edit', function(req, res) {
    var collection = db.get('videos');
    collection.findOne({ _id: req.params.id }, function(err, video){
        if (err) throw err;
        res.render('edit', { video: video });
    });
});

//update video
router.post('/videos/:id/edit', function(req, res){
    var collection = db.get('videos');
    var query = {_id: req.params.id};
    var newvalues = { $set: 
                        {   
                            title: req.body.title, 
                            genre: req.body.genre,
                            image: req.body.image,
                            description: req.body.desc 
                        } 
                    };
    collection.update(query, newvalues, function(err, video){
        if (err) throw err;
        res.redirect('/videos');
    });
});

module.exports = router;
