

class SimpleForm extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      value: '',
      user_result: '',
      math_error: ''
    };
  }

  checkMaths() {
    let calc_result;
    if (this.props.maths.operand === 'times') {
      calc_result = this.props.maths.x * this.props.maths.y;
    }

    let user_result_trimmed = this.state.user_result.trim()
    if (user_result_trimmed.length == 0) {
      return "";
    }

    if ("" + calc_result != user_result_trimmed) {
      return "Nope, that's wrong";
    }
    return "";
  }

  cityUpdateHandler(city) {
    this.setState({
      timeoutID: undefined
    });

    const success_callback = (data) => {
      this.setState({weather_conditions: data})
    };

    this.props.weather_fetcher(city, success_callback);
  }

  handleMathsChange(event) {
    this.setState({user_result: event.target.value});
  }

  render() {
    let math_error_notice = this.checkMaths();

    if (math_error_notice.length != 0) {
      //math_error_notice = <span className="error">{math_error_notice}</span>;
      math_error_notice = <img src="/images/Wrong.gif" />
    }

    return (
      <div>
        <div><input type="text" placeholder="Email" value={this.state.email} size="50"/> </div>

        <div>
          <textarea placeholder="Ask your question" value={this.state.question} rows="4" cols="50"/>
        </div>

        <div>What is 2 times 4?</div>

        <div>
          <input type="text" placeholder="" value={this.state.user_result} onChange={(e) => this.handleMathsChange(e)}/>
          <span><br/>{math_error_notice}</span>
        </div>

        <div><input type="submit" value="Submit" /></div>

      </div>
    );
  }
}



ReactDOM.render(
    <SimpleForm maths={{x: 2, y: 4, operand: 'times'}} />,
    document.getElementById('simple_form')
);