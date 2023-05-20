import React, { Component } from 'react';

class App extends React.Component {

  constructor( props ) {
    super( props );
    this.state = {
      posts: []
    };
  }

  componentDidMount() {
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


    // declare the state variable as a constant



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

  return false;
}

// function to generate a row to display in the block for each staff member
createRow(item) {
  let thePermalink = item.link;
  let featured_image = item._embedded['wp:featuredmedia'][0].source_url;
  let image1 = item.cmb2.Brothman_Portfolio_metabox.Brothman_Portfolio_image1;
//   let theBio = item.cmb2.rothman_Portfolio_metabox.br_bio;
//   let thePortrait = item.cmb2.rothman_Portfolio_metabox.br_portrait;
  let theTitle = item.title.rendered;

  // create the row for the post using the data entered into the fields on the dashboard \\
  let theRow = <div class="col-lg-3 col-md-2 col-sm-12 bp_portfolio_item_cell">

							<a href={thePermalink}>
									<img class="portfolio-grid-box-image" src={featured_image} />
                  <p>{theTitle}</p>
							</a>

      				</div>;

  return theRow;
}

  render() {
    return (
      <div>
        {this.createRows()}
      </div>
    );
  }
}

export default App;