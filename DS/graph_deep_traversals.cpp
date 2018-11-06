#include <iostream>
#include <string>
#include <cstring>
using namespace std;

const int MaxLen = 20;//graph max 20 node

class Map{
    private:
        bool visit[MaxLen];
        int matrix[MaxLen][MaxLen]; // Neighbor Mx
        int node_num;

        void DFS(int v);

    public:
        void setMx(int n_num,int mx[MaxLen][MaxLen]);
        void DFSTraverse();

};


void Map::setMx(int n_num,int mx[MaxLen][MaxLen]){
    int i,j;
    node_num = n_num;

    //init matrix
    for(i=0;i<MaxLen;i++){
        for(j=0;j<MaxLen;j++){
            matrix[i][j] = 0;
        }
    }

    //fill mx
    for(i=0;i<node_num;i++){
        for(j=0;j<node_num;j++){
            matrix[i][j] = mx[i][j];
        }
    }

}

// DFS
void Map::DFS(int v){
    int w,i,j,k,len;

    visit[v] = true;
    cout<<v<<" ";


    int *AdjVex = new int [node_num];

    //init
    for(i=0;i<node_num;i++){

        AdjVex[0] = -1;
    }

    //found connected
    for(i=0,j=0;i<node_num && j<node_num;i++){
         if(matrix[v][i]==1){
            AdjVex[j] = i; // i node is connected
            j++;
         }
    }

    //traversals
      for(i=0;i<node_num && AdjVex[i]!=-1 ;i++){
        //todo 确认为方便 递归深度遍历

      }


}


void Map::DFSTraverse(){
    int v;

    for(i=0;i<node_num;i++){
        if(visit[i]!=true){
            DFS(i);
        }
    }

    cout<<endl;

}





