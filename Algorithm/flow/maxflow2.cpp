#include <iostream>
#include <algorithm>
#include <stdio.h>
#include <string.h>
#include <queue>
using namespace std;
using namespace std;
const int maxn=20;
const int inf=0x3f3f3f3f;
int pre[maxn];   //����ǰ���ڵ�
bool vis[maxn];
int mp[maxn][maxn];//�ٽӾ��󱣴��������

int s,e;//sΪԴ�㣬eΪ���
int n,m;//����n�����㣬m����

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
			return true;//�ҵ�һ������·
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
		if(!bfs())//�Ҳ�������·
			return ans;
		int Min=inf;
		for(int i=e; i!=s; i=pre[i]) //��������С����
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
