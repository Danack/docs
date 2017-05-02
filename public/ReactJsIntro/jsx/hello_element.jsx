

class HelloElement extends React.Component {
  render() {
    return (
      <div>
        <h2>Hello {this.props.name}! This is some ReactJS.</h2>
      </div>
    );
  }
}

ReactDOM.render(
  <HelloElement name="PHPSW" />,
  document.getElementById('react_hello_element_1')
);