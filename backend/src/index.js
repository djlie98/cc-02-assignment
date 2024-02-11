const express = require("express");
const app = express();
const port = 3000;
const pg = require("pg");
const cors = require("cors");

require("dotenv").config();

const pool = new pg.Pool({
  user: process.env.PG_USER,
  host: process.env.PG_HOST,
  database: process.env.PG_DB,
  password: process.env.PG_PASS,
  port: process.env.PG_PORT,
});

pool.query(
  "CREATE TABLE IF NOT EXISTS todos(id SERIAL PRIMARY KEY, msg VARCHAR(255), done BOOLEAN)"
);

app.use(express.json());
app.use(express.urlencoded());
app.use(cors());

app.get("/", async (req, res) => {
  const data = await pool.query("SELECT * FROM todos");
  res.send({
    todos: data.rows,
  });
});

app.post("/", async (req, res) => {
  const data = req.body;
  const query = {
    text: "INSERT INTO todos VALUES(DEFAULT, $1, $2)",
    values: [data.msg, false],
  };
  await pool.query(query);
  const result = await pool.query("SELECT * FROM todos");

  res.send(result.rows);
});

app.post("/:id", async (req, res) => {
  const query = {
    text: "UPDATE todos SET done = true WHERE id = $1",
    values: [req.params.id],
  };
  await pool.query(query);
  const result = await pool.query("SELECT * FROM todos");

  res.send(result.rows);
});

app.listen(port, () => {
  console.log(`Todo app listening on port ${port}`);
});
