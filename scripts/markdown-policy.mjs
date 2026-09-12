export function rejectHtml() {
  return (tree, file) => {
    function visit(node) {
      if (node.type === 'html') file.fail('Raw HTML is not allowed in library Markdown. Use Markdown or a fenced code example.', node);
      for (const child of node.children ?? []) visit(child);
    }
    visit(tree);
  };
}
