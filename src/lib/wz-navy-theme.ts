export const wzNavyTheme = {
  name: 'webberzone-navy',
  type: 'dark' as const,
  colors: {
    'editor.background': '#1a2e3a',
    'editor.foreground': '#f7f3ee',
  },
  tokenColors: [
    { scope: ['comment', 'punctuation.definition.comment'], settings: { foreground: '#7d8e98', fontStyle: 'italic' } },
    { scope: ['string', 'string.quoted', 'constant.character.escape'], settings: { foreground: '#ffbd59' } },
    { scope: ['keyword', 'keyword.control', 'keyword.operator', 'storage', 'storage.type', 'storage.modifier'], settings: { foreground: '#7fc1cf' } },
    { scope: ['entity.name.function', 'support.function'], settings: { foreground: '#f7f3ee' } },
    { scope: ['variable', 'variable.other', 'variable.parameter'], settings: { foreground: '#a3d4de' } },
    { scope: ['constant', 'constant.numeric', 'constant.language', 'support.constant'], settings: { foreground: '#e08d6d' } },
    { scope: ['punctuation', 'meta.brace'], settings: { foreground: '#9fb3bd' } },
    { scope: ['entity.name.type', 'entity.name.class', 'support.class', 'support.type'], settings: { foreground: '#7fc1cf' } },
  ],
};
