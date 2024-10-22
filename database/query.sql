GO

/****** Object:  Table [dbo].[ref_kcu]    Script Date: 10/16/2024 10:25:31 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[ref_kcu](
  [table1] [varchar](50) NULL,
  [table12] [varchar](50) NULL,
  [table3] [varchar](50) NULL
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

/****** Object:  Table [dbo].[Ref_KCU_KC]    Script Date: 10/16/2024 10:25:31 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[Ref_KCU_KC](
  [Regional] [varchar](50) NULL,
  [Nama_Pos_Dirian] [varchar](50) NULL,
  [Nopen] [varchar](50) NULL,
  [Jenis_Kantor] [varchar](50) NULL,
  [Nama_Kantor] [varchar](50) NOT NULL,
  [Singkatan] [varchar](50) NULL,
  [Nopen_KCU] [varchar](50) NULL,
  [Nama_KCU] [varchar](50) NULL,
  [Nopen_KCU_KC] [varchar](50) NULL,
  [Nama_KCU_KC] [varchar](50) NULL,
  [Tipe_Kantor] [varchar](50) NULL,
  [Alamat] [varchar](50) NULL
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

/****** Object:  Table [dbo].[Ref_KCU_KC_Terbaru]    Script Date: 10/16/2024 10:25:31 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[Ref_KCU_KC_Terbaru](
  [kdregional] [varchar](50) NULL,
  [Nopen_KCU] [varchar](50) NOT NULL,
  [Nopen_KCU_KC] [varchar](50) NOT NULL,
  [Nama_KCU_KC] [varchar](50) NULL,
 CONSTRAINT [PK_Ref_KCU_KC_Terbaru1] PRIMARY KEY CLUSTERED 
(
  [Nopen_KCU] ASC,
  [Nopen_KCU_KC] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, FILLFACTOR = 90) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO