# frontend/Dockerfile

FROM node:23-alpine

# 作業ディレクトリを指定
WORKDIR /app

# 依存ファイルを先にコピーしてinstall（キャッシュ効かせる）
COPY package*.json ./
RUN npm install

# アプリ本体をコピー
COPY . .

# デフォルトはnpm run dev（docker-compose.ymlで上書きもできる）
CMD ["npm", "run", "dev", "--", "--host"]
