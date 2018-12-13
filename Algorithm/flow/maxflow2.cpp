#include <iostream>
#include <algorithm>
#include <stdio.h>
#include <string.h>
#include <queue>
using namespace std;
using namespace std;
const int maxn=20;
const int inf=0x3f3f3f3f;
int pre[maxn];   //保存前驱节点
bool vis[maxn];
int mp[maxn][maxn];//临接矩阵保存残留网络

int s,e;//s为源点，e为汇点
int n,m;//输入n个顶点，m条边

bool bfs() {
	queue<int>q;
	memset(pre,0,sizeof(pre));
	memset(vis,0,sizeof(vis));
	vis[s]=1;
	q.push(s);
	while(!q.empty()) {
		int first=q.front();
		q.pop();
		if(first==e)
			return true;//找到一条增广路
		for(int i=1; i<=n; i++) {
			if(!vis[i]&&mp[first][i]) {
				q.push(i);
				pre[i]=first;
				vis[i]=1;
			}
		}
	}
	return false;
}

int max_flow() {
	int ans=0;
	while(1) {
		if(!bfs())//找不到增广路
			return ans;
		int Min=inf;
		for(int i=e; i!=s; i=pre[i]) //回溯找最小流量
			Min=min(Min,mp[pre[i]][i]);
		for(int i=e; i!=s; i=pre[i]) {
			mp[pre[i]][i]-=Min;
			mp[i][pre[i]]+=Min;
		}
		ans+=Min;
	}
}

int main() {
	int t;
	scanf("%d",&t);
	int u,v,c;
	for(int cas=1; cas<=t; cas++) {
		scanf("%d%d",&n,&m);
		s=1,e=n;
		memset(mp,0,sizeof(mp));
		while(m--) {
			scanf("%d%d%d",&u,&v,&c);
			mp[u][v]+=c;
		}
		printf("Case %d: %d\n",cas,max_flow());
	}
	return 0;
}
