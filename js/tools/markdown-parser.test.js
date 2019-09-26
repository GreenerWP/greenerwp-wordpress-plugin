import MarkdownParser from './markdown-parser.js';

test('test link replacement', () => {
  var parser = new MarkdownParser();
  var input = 'foo [Link test](https://thelink) bar [foo](https://bar) ';
  var output = 'foo <a href="https://thelink" target="_blank">Link test</a> bar <a href="https://bar" target="_blank">foo</a> ';
  expect( parser.parse( input ) ).toBe( output );
});
