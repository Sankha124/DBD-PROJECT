import React from 'react'

class VideoList extends React.Component {

  render() {

    return (
    <div>
    <h1>Videos</h1>
        {this.props.videos.map((video,i) => (
            
    <div className="card" key={i}>
    <div className="card-body">
    <h5 className="card-title">{video.title}</h5>
    <h6 className="card-subtitle mb-2 text-muted">{video.genre}</h6>
    <p className="card-text">{video.description}</p>
    </div>
    </div>
    ))}
        </div> 
    );
  }
}

export default VideoList;