import React, { Component } from 'react';
import Videos from './components/VideoList';
import './App.css';
  
class App extends Component{  
  constructor(props) {
    super(props);
        this.state = {
          videos: [],
          filterd_Videos: [],
          searchString: ''
        };
  this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }
        componentDidMount(){
          fetch('http://localhost:3000/api/videos')
          .then(res => res.json())
          .then((data) => {
            this.setState({videos: data, filterd_Videos: data})
          })
        }
   
    
  handleChange(e) {
    this.setState({ searchString: e.target.value });
  }
    
  handleSubmit(e) {
    e.preventDefault();
    let currentList = [];
     if (this.state.searchString !== "") {     
        currentList = this.state.videos.filter(name => name.title.toLowerCase().includes(this.state.searchString.toLowerCase()))  
        this.setState.searchString = ''   
        
       } else {
         currentList = this.state.videos;       
       }

      this.setState({
        filterd_Videos: currentList
      })  
  }
  
        render() {
        return (            
          <div>
          <form >
          <label>SEARCH
          <input type="text" value={this.state.searchString} onChange={this.handleChange}/>
          </label>
          <button onClick={this.handleSubmit} >Submit</button>
          </form>
          <Videos videos={this.state.filterd_Videos} />
          </div>
          )
      }
    }

    export default App;