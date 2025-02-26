const path = require("path");

module.exports = {
  entry: "./src/index.js", // Your main React file
  output: {
    path: path.resolve(__dirname, "assets/js"),
    filename: "bundle.js",
  },
  module: {
    rules: [
      {
        test: /\.js$/, // Apply babel-loader to JavaScript files
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
          options: {
            presets: ["@babel/preset-env", "@babel/preset-react"],
          },
        },
      },
    ],
  },
  resolve: {
    extensions: [".js", ".jsx"],
  },
  mode: "development", // Change to "production" for production builds
};
