#include <iostream>
#include <string>
#include <cstring>
using namespace std;

const int MaxLen = 20;//graph max 20 node

class Map {
	private:
		bool visit[MaxLen];
		int matrix[MaxLen][MaxLen]; // Neighbor Mx
		int node_num;

		void DFS(int v);

	public:
		void setMx(int n_num,int** mx);
		void DFSTraverse();

};


void Map::setMx(int n_num,int** mx) {
	int i,j;
	node_num = n_num;

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

// DFS
void Map::DFS(int v) {
	int w,i,j,len,next;

	visit[v] = true;
	cout<<v<<" ";


	int *AdjVex = new int [node_num];

	//init
	for(i=0; i<node_num; i++) {
		AdjVex[i] = -1;
	}

	//found connected
	for(i=0,j=0; i<node_num && j<node_num; i++) {
		if(matrix[v][i]==1) {
//		    cout<<"mx["<<v<<"][i]"<<endl;
//			cout<<"aj:"<<i<<endl;
			AdjVex[j] = i; // i node is connected
			j++;
		}
	}

	//traversals
	for(i=0; i<node_num ; i++) {
	    next = AdjVex[i];
	    if(next == -1){
	        break;
	    }
		//递归深度遍历
		if(visit[next]!=true) {
			DFS(next);
		}
	}

	delete []AdjVex;
}


void Map::DFSTraverse() {
	int i,v;

	for(i=0; i<node_num; i++) {
		if(visit[i]!=true) {
			DFS(i);
		}
	}

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
		    for(j=0;j<n;j++){
                cin>>mx[i][j];
		    }
		}

		map = new Map();
		map->setMx(n,mx);
		map->DFSTraverse();

		delete[] map;

	}

return 0;

}





