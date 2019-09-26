class MarkdownParser {
  parse(text) {
    return text.replace(
      /\[([^\]]*?)\]\((https?:\/\/.*?)\)/g,
      '<a href="$2" target="_blank">$1</a>'
    );
  }
};

export default MarkdownParser;
