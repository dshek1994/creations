import React, {useState} from 'react';
import Tweet from './Tweet';

function App(){
  const [users, setUsers] = useState([
    {name: "Dan", message: "Hello there"},
    {name: "Fred", message: "My first tweet"},
    {name: "John", message: "What is this this"}
  ]);
  return(
    <div className="app">
      {users.map(user => (
        <Tweet name={user.name} message={user.message} />
      ))}
    </div>
  );
}

export default App;