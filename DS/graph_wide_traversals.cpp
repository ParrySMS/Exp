#include <iostream>
#include <string>
#include <cstring>
#include <queue>
#include <assert.h>
using namespace std;

const int MaxLen = 20;//graph max 20 node

class Map {
	private:
		bool visit[MaxLen];
		bool wait[MaxLen];
		int matrix[MaxLen][MaxLen]; // Neighbor Mx
		int node_num;

		void BFS(int v,queue <int> q);

	public:
		void setMx(int n_num,int** mx);
		void BFSTraverse();

};


void Map::setMx(int n_num,int** mx) {
	int i,j;
	node_num = n_num;

	//init visit
	for(i=0; i<MaxLen; i++) {
		visit[i]=false;
		wait[i]=false;
	}
	
	//init matrix
	for(i=0; i<MaxLen; i++) {
		for(j=0; j<MaxLen; j++) {
			matrix[i][j] = 0;
		}
	}

	//fill mx
	for(i=0; i<node_num; i++) {
		for(j=0; j<node_num; j++) {
			matrix[i][j] = mx[i][j];
		}
	}

}


void Map::BFSTraverse() {
	queue <int> q;
	BFS(0,q);
}

void Map::BFS(int v,queue <int> q) {
	int head,next;
	int i,j;
	int *AdjVex = new int [node_num];


	//init
	for(i=0; i<node_num; i++) {
		AdjVex[i] = -1;
	}


	for(; v<node_num ; ++v) { //all not visit node
	
		if(visit[v]==true){
			continue;
		}
		
		q.push(v);

		while(!q.empty()) {
			head = q.front();
			visit[head] = true;
			cout<<head<<" ";
			q.pop();

			//found connected
			for(i=0,j=0; i<node_num && j<node_num; i++) {
				if(matrix[head][i]==1) {
//					cout<<"mx["<<v<<"][i]"<<endl;
//					cout<<"aj:"<<i<<endl;
					AdjVex[j] = i; // i node is connected
					j++;
				}
			}

			//traversals
			for(i=0; i<node_num ; i++) {
				next = AdjVex[i];
				if(next == -1) {
					break;
				}
				//递归深度遍历
				if(!visit[next] && !wait[next]) {
					q.push(next);
					wait[next]=true;
				}
			}

		}//end while

	}//all not visited
	
	cout<<endl;

}


int main() {
	int i,j,k,t,n;
	Map* map;
	int** mx;

	cin>>t;
	while(t--) {
		cin>>n;

		mx = new int* [n];//line
		for(i=0; i<n; i++) {//col
			mx[i] = new int [n];
		}

		//fill
		for(i=0; i<n; i++) {
			for(j=0; j<n; j++) {
				cin>>mx[i][j];
			}
		}

		map = new Map();
		map->setMx(n,mx);
		map->BFSTraverse();

		delete[] map;

	}

	return 0;

}






