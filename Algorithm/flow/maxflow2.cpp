#include <iostream>
#include <stdio.h>
#include <string.h>
#include <queue>
using namespace std;
using namespace std;
const int MAX = 20;
const int MAX_FLOW = 99999;
const int NULL_NODE = -1;
int pre[MAX];   //ǰ�ڵ�
bool vis[MAX]; //�Ƿ񱻷���
int mx[MAX][MAX];//�ٽӾ��󱣴��������

int s,e;//sΪԴ�㣬eΪ���
int n,m;//����n�����㣬m����

bool bfs() {
	queue<int>q;
	int i;

	for(i=0; i<MAX; i++) {
		pre[i] = NULL_NODE;
		vis[i] = false;
	}

	vis[s]=true;
	q.push(s);

	while(!q.empty()) {
		int head = q.front();
		q.pop();
		if(head == e) return true;//����·

		for(int i=1; i<=n; i++) {  //���
			if(!vis[i] && mx[head][i]) {
				q.push(i);
				pre[i] = head;
				vis[i]=true;
			}
		}
	}
	return false;
}

int max_flow() {
	int i,flow=0;
	while(1) {
		if(!bfs()) break;

		int min_flow = MAX_FLOW;
		for( i=e; i!=s; i=pre[i]) //��������С����
			min_flow =  mx[pre[i]][i] <min_flow? mx[pre[i]][i]:min_flow  ;

		for( i=e; i!=s; i=pre[i]) {
			mx[pre[i]][i]-=min_flow;
			mx[i][pre[i]]+=min_flow;
		}
		flow+=min_flow;
	}

	return flow;
}

int main() {
	int i,j,k,t;
	scanf("%d",&t);
	int u,v,c;
	for( k=1; k<=t; k++) {
		scanf("%d%d",&n,&m);
		s=1,e=n;

		memset(mx,0,sizeof(mx));

		while(m--) {
			scanf("%d%d%d",&u,&v,&c);
			mx[u][v] += c;
		}
		printf("Case %d: %d\n",k,max_flow());
	}
	return 0;
}
