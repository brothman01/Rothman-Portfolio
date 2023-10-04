import React, { Component } from 'react';
import './style.scss';
import spinner from './assets/spinner.gif';

class App extends React.Component {

  constructor( props ) {
    super( props );
    this.state = {
      posts: [],
      showSpinner: true
    };
  }


  componentDidMount() {
    // start the timer for the spinner display
    this.timer = setInterval(() => {
      this.setState({showSpinner: false})
    }, 3000);

    // Fetch the data from the URL
    const theUrl = window.location.origin + "/wp-json/wp/v2/portfolio_item?filter[orderby]=date&order=desc&per_page=50&post_status=published&_embed";
    fetch(theUrl)
    .then(response => response.json())
    .then(response => // set the posts to the state variable 'posts' in the second then()
      this.setState({
        posts: response,
      })
    )
  }



  createRows = () => {
        const { posts } = this.state;

    // check if posts exists and has a non-zero length
    if (posts && posts.length) {


      const listItems = posts.map( ( post, index ) =>
        this.createRow(post)
      );

      const logPosts = posts.map( ( post, index ) =>
        console.log(post)
      );

      return listItems;

    }

    return <p>There are no items to render.</p>;
  }

  // function to generate a row to display in the block for each staff member
  createRow(item) {
    let thePermalink = item.link;
    let featured_image = item._embedded['wp:featuredmedia'][0].source_url;
    let theTitle = item.title.rendered;

    // create the row for the post using the data entered into the fields on the dashboard \\
    let theRow = <div class="col-lg-3 col-md-2 col-sm-12 bp-portfolio-item-cell">

                <a href={thePermalink}>
                    <img class="portfolio-grid-box-image" src={featured_image} />
                    <p>{theTitle}</p>
                </a>

                </div>;

    return theRow;
  }

  render() {
      // clearInterval(this.timer);
      var divStyle = {
        top: '0',
        left: '0',
        width: '100%',
        height: '100%'
      };
      
      
      return (
        <div className="portfolio-page md-col-12">
          <div className="portfolio-container">
          { true == this.state.showSpinner &&
          <div className="spinner-div" style={divStyle}>
              <img src={spinner} style={{ margin: '0px auto' }} alt="Spinner" />
            </div>
          }
            <div style={{ visibility: this.state.showSpinner ? 'hidden' : 'visible' }}>
              {this.createRows()}
            </div>
          </div>
        </div>
      );

  }
}

export default App;