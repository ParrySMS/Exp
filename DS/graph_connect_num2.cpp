
#include <iostream>
#include <string>
#include <queue>

using namespace std;

#define MAX 20

class Map {
	private:
		bool visit[MAX];
		int map_mx[MAX][MAX];
		int map_node_num;
		void BFS(int v);
	public:
		void SetMap_mx(int vnum,int **mx);
		void BFSTraverse();
		int get();
};

void Map::BFSTraverse() {
	cout<<0<<' ';
	visit[0]=true;
	BFS(0);
	cout<<endl;
}


int Map::get() {
	int i,sum=0;
	for(i=0; i<map_node_num; i = i+1) {
		if(!visit[i]) {
			BFS(i);
			sum++;
		}
	}
	return sum;
}


void Map::BFS(int v) {
	visit[v]=true;
	queue<int> Q;
	for(int i=0; i<map_node_num; i++) {
		if(map_mx[v][i]!=0 &&!visit[i]) {
			Q.push(i);
		}
	}

	while(!Q.empty()) {
		BFS(Q.front());
		Q.pop();
	}
}

void Map::SetMap_mx(int vnum,int **mx) {


	int i,j;
	for(i=0; i<map_node_num; i++)
		visit[i]=false;

	map_node_num = vnum;

//init mx
	for(i=0; i<MAX; i++)
		for(j=0; j<MAX; j++)
			map_mx[i][j]=0;

//filled
	for(i=0; i<map_node_num; i++)
		for(j=0; j<map_node_num; j++)
			map_mx[i][j]=mx[i][j];
}



void count() {
	int i,j,n,k;
	int **m;

	cin>>n;
	string *s=new string[n];
	for(i=0; i<n; i = i+1)
		cin>>s[i];

	m = new int*[n];

	for(i=0; i<n; i = i+1) {
		m[i]=new int[n];
		for(j=0; j<n; j++)
			m[i][j]=0;
	}

	cin>>k;

	string var_t1,var_t2;
	int x,y;
	for(int i=0; i<k; i = i+1) {
		cin>>var_t1>>var_t2;
		for(int p=0; p<n; p++) {
			if(s[p]==var_t1) {
				x=p;
			}

			if(s[p]==var_t2) {
				y=p;
			}
		}

		m[x][y]=1;
		m[y][x]=1;
	}

	for(i=0; i<n; i = i+1) {
		if(i==n-1)
			cout<<s[i];
		else
			cout<<s[i]<<' ';
	}
	cout<<endl;

	for(i=0; i<n ; i = i+1) {
		for(j=0; j<n; j++) {
			if(j==n-1) {
				cout<<m[i][j];
			} else {
				cout<<m[i][j]<<' ';
			}
		}
		cout<<endl;
	}

	Map map;
	map.SetMap_mx(n,m);
	cout<<map.get()<<endl<<endl;
}

int main() {
	int t;
	cin>>t;
	while(t--) {
		count();
	}

}
