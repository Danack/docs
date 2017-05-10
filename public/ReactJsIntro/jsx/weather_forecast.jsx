
function handleErrors(response) {
  if (!response.ok) {
    throw Error(response.statusText);
  }
  return response;
}

class WeatherSearchBox extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      value: '',
    };
  }

  handleChange(event) {
    if (this.state.timeoutID !== undefined) {
       clearTimeout(this.state.timeoutID);
    }
    let newTimeoutID = setTimeout(() => this.props.handler(this.state.value), 600);
    this.setState({
      timeoutID: newTimeoutID
    });

    this.setState({value: event.target.value});
  }

  handleBlur() {
    this.props.handler(this.state.value);
  }

  render() {
    return (
      <div className='react_input'>
        <input type="text"
           name="location"
               value={this.state.value}
           placeholder="Enter a city"
           onChange={(e) => this.handleChange(e)}
           onBlur={(e) => this.handleBlur(e)}/>
      </div>
    );
  }
}

function ListItem(props) {
    const wc = props.weather_condition;
    const styles = {width: '100px', marginBottom: "-35px"};

    return (
      <li><span>{wc.time}
          <img src={"" + wc.icon} style={styles}/> {wc.description} : {wc.temp}
      </span></li>)
}

class WeatherResults extends React.Component {
  render() {
    const listItems = this.props.weather_conditions.map((weather_condition) =>
      <ListItem key={weather_condition.dt}
                weather_condition={weather_condition} />
    );
    return (
      <div >
        {listItems}
      </div>
    );
  }
}

class WeatherForecast extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      weather_conditions: []
    };
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

  render() {
    return (
      <div>
        <WeatherSearchBox handler={(city) => this.cityUpdateHandler(city)} />
        <WeatherResults weather_conditions={this.state.weather_conditions} />
      </div>
    );
  }
}

const weather_fetcher = function (city, onSuccess) {
  fetch('/ReactJsIntro/getWeather.php?city=' + encodeURI(city))
    .then(handleErrors)
    .then((response) => response.json())
    .then(
      onSuccess
    )
    .catch((err) => {
      alert('error:' + err);
    });
};


ReactDOM.render(
    <WeatherForecast weather_fetcher={weather_fetcher}/>,
    //<WeatherForecast weather_fetcher={weather_fetcher_stub}/>,
    document.getElementById('weather_forecast')
);




const weather_fetcher_stub = function (city, onSuccess) {
  let data = [{
    "dt": 12345,
    "temp": "20",
    "time": "Thur 3pm",
    "description": "warm grey",
    "icon": "http://openweathermap.org/img/w/03d.png"
  }];
  onSuccess(data);
};

ReactDOM.render(
  <WeatherForecast weather_fetcher={weather_fetcher_stub}/>,
  document.getElementById('weather_forecast_mock')
);
