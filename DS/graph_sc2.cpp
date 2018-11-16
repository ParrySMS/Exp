#include<iostream>
using namespace std;

#define MAX 20


class Map {
	private:
		bool visit[MAX];
		int matrix[MAX][MAX];
		int node_num;
		void DFS(int v) {
			int w, i, k=0;

			visit[v]= true;
			//cout<<v<<' ';
			sum++;

			int *adjvex= new int[node_num];

			for(i= 0; i< node_num; i++)
				adjvex[i]= -1;



			for(i= 0; i< node_num; i++) {
				if(matrix[v][i]) {
					adjvex[k++]= i;
				}
			}


			for(i=0,w= adjvex[i++]; w>= 0; w= adjvex[i++]) {
				if(!visit[w])
					DFS(w);
			}
		}
	public :
		int sum;
		void setmatrix(int node_num, int mx[MAX][MAX]) {
			int i, j;
			this->node_num = node_num;
			for(i= 0; i< MAX; i++) {
				for(j= 0; j< MAX; j++) {
					matrix[i][j]= 0;
				}
			}

			for(i= 0; i< MAX; i++) {
				for(j= 0; j< node_num; j++) {
					matrix[i][j]= mx[i][j];
				}
			}
		}

		void DFSTraverse(int v) {
			for(int i= 0; i< node_num; i++) {
				visit[i]= false;
				int k= 0;
			}
			DFS(v);
		}

		int travel() {
			for(int i= 0; i< node_num; i++) {
				for(int j= 0; j< node_num; j++)
					visit[j]= false;
				sum= 0;
				DFSTraverse(i);
				if(sum!= node_num)
					return 0;
			}

			return 1;
		}
};

int main() {
	int t;
	cin>>t;
	while(t--) {
		int n;
		cin>>n;
		int mx[MAX][MAX];

		for(int i= 0; i< n; i++)
			for(int j= 0; j< n; j++)
				cin>>mx[i][j];


		Map* map;
		map= new Map();
		map->setmatrix(n, mx);

		if(map->travel()) {
			cout<<"Yes"<<endl;
		} else {
			cout<<"No"<<endl;
		}
	}
}

